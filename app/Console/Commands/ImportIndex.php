<?php
/**
 * Class ImportIndex
 *
 * @date      7/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Console\Commands;

use App\Models\AppLog;
use App\Models\Todo;
use App\Services\ElasticsearchService;
use Illuminate\Console\Command;

/**
 * Class ImportIndex
 *
 * Command to import all indexes.
 */
class ImportIndex extends Command
{
    /**
     * Counter for the number of items successfully indexed.
     *
     * @var $counter
     */
    protected $counter;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:importIndex {--index=} {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import index for Elasticseach';

    /**
     * Execute the console command.
     *
     * @param ElasticsearchService $elastic
     * @return void
     */
    public function handle(ElasticsearchService $elastic)
    {
        $this->info('Preparing items to be indexed');

        // array of allowable indexes and types
        $allowedIndexes = ['todo'];
        $allowedTypes   = ['todo'];

        $db        = app('db');
        $indexName = !empty($this->option('index')) ? $this->option('index') : 'todo';
        $typeName  = !empty($this->option('type')) ? $this->option('type') : 'todo';
        $table     = str_plural($indexName);

        if (!in_array($indexName, $allowedIndexes)) {
            $this->info('No such index exists. ABORTED');
            return;
        }

        if (!in_array($typeName, $allowedTypes)) {
            $this->info('No such type exists. ABORTED');
            return;
        }

        try {
            // Get total count to index
            $totalCount    = (int)$db->table($table)->selectRaw('COUNT(*) as `count`')->value('count');
            $this->counter = 0;
        } catch (\Exception $e) {
            $this->info('No such table exists. ABORTED');
            return;
        }

        $this->comment($totalCount . ' items found to be indexed.');

        $bar = $this->output->createProgressBar($totalCount);

        app('db')->table($table)
            ->selectRaw('todos.*, users.name AS `user_name`, categories.name AS `category_name`')
            ->leftJoin('users', 'users.id', '=', 'todos.user_id')
            ->leftJoin('categories', 'categories.id', '=', 'todos.category_id')
            ->chunk(1000, function ($items) use ($elastic, $bar, $indexName, $typeName) {
                if ($indexName == 'todo') {
                    foreach ($items as $item) {
                        try {
                            $elastic->index($this->prepareTodoParameter($item));
                            $this->counter++;
                        } catch (\Exception $e) {
                            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                                get_class($e), [
                                'message' => $e->getMessage(),
                                'code'    => $e->getCode(),
                                'file'    => $e->getFile(),
                                'line'    => $e->getLine(),
                                'item_id' => $item->id
                            ]);
                        }

                        $bar->advance(1);
                    }
                }
            });

        $bar->finish();

        $this->info(PHP_EOL . $this->counter . '/' . $totalCount . ' indexes imported successfully!');
    }

    /**
     * Prepare the item to be indexed
     *
     * @param Todo $item
     * @return array
     */
    protected function prepareTodoParameter($item)
    {
        return [
            'index' => 'todo_index',
            'type'  => 'todo_type',
            'id'    => (int)$item->id,
            'body'  => [
                'id'            => (int)$item->id,
                'uid'           => $item->uid,
                'title'         => $item->title,
                'description'   => $item->description,
                'category_id'   => (int)$item->category_id,
                'category_name' => $item->category_name,
                'user_id'       => (int)$item->user_id,
                'user_name'     => $item->user_name,
                'created_at'    => $item->created_at,
                'updated_at'    => $item->updated_at,
                'deleted_at'    => $item->deleted_at
            ]
        ];
    }
}
