<?php
/**
 * Class ImportIndex
 *
 * @date      7/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Console\Commands;

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

        app('db')->table($table)->chunk(1000, function ($items) use ($elastic, $bar, $indexName, $typeName) {
            if ($indexName == 'todo') {
                foreach ($items as $item) {
                    try {
                        $elastic->index($this->prepareTodoParameter($item));
                        $this->counter++;
                    } catch (\Exception $e) {
                        // skip
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
            'id'    => $item->id,
            'body'  => [
                'id'          => $item->id,
                'uid'         => $item->uid,
                'title'       => $item->title,
                'description' => $item->description,
                'category_id' => $item->category_id,
                'user_id'     => $item->user_id,
                'created_at'  => $item->created_at,
                'updated_at'  => $item->updated_at,
                'deleted_at'  => $item->deleted_at
            ]
        ];
    }
}
