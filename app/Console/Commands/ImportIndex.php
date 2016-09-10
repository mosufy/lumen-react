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
use App\Repositories\TodoRepository;
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
     * @param TodoRepository       $todoRepository
     * @return void
     */
    public function handle(ElasticsearchService $elastic, TodoRepository $todoRepository)
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

        $this->comment('Deleting existing indexes');
        try {
            $elastic->drop(['index' => env('ELASTICSEARCH_INDEX', 'todo_index')]);
        } catch (\Exception $e) {
            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                'Failed to drop index. Likely due to no such index found.', [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine()
            ]);
        }

        try {
            // Get total count to index
            $this->comment('Existing indexes deleted successfully. Counting documents to index');
            $totalCount    = (int)$db->table($table)->selectRaw('COUNT(*) as `count`')->whereNull('todos.deleted_at')->value('count');
            $this->counter = 0;
        } catch (\Exception $e) {
            $this->info('No such table exists. ABORTED');
            return;
        }

        if ($totalCount <= 0) {
            $this->info('0 documents found to be indexed. ABORTED');
            die();
        }

        $this->comment($totalCount . ' items found to be indexed.');

        $bar = $this->output->createProgressBar($totalCount);

        app('db')->table($table)
            ->selectRaw('todos.*, users.name AS `user_name`, categories.name AS `category_name`')
            ->leftJoin('users', 'users.id', '=', 'todos.user_id')
            ->leftJoin('categories', 'categories.id', '=', 'todos.category_id')
            ->whereNull('todos.deleted_at')
            ->chunk(1000, function ($items) use ($elastic, $bar, $indexName, $typeName, $todoRepository) {
                if ($indexName == 'todo') {
                    foreach ($items as $item) {
                        try {
                            $elastic->index($todoRepository->prepareTodoParameter($item));
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
}
