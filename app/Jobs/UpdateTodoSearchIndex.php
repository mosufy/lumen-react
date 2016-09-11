<?php
/**
 * Class UpdateTodoSearchIndex
 *
 * @date      10/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Jobs;

use App\Models\AppLog;
use App\Repositories\TodoRepository;
use Illuminate\Contracts\Cache\Repository as Cache;

/**
 * Class UpdateTodoSearchIndex
 *
 * Add, update, delete Todos index.
 */
class UpdateTodoSearchIndex extends Job
{
    protected $todo, $action;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Todo $todo
     * @param string           $action
     */
    public function __construct($todo, $action)
    {
        $this->todo   = $todo;
        $this->action = $action;
    }

    /**
     * Execute the job.
     *
     * @param TodoRepository $todoRepository
     * @return void
     */
    public function handle(TodoRepository $todoRepository, Cache $cache)
    {
        // Calculate exponential retry time
        $attempts        = $this->attempts();
        $base_sec        = 2;
        $max_sec         = 300;
        $next_retry_time = min((int)($base_sec * pow(2, $attempts - 1)), $max_sec);
        $retry_limit     = 50;

        if ($attempts > $retry_limit) { // @codeCoverageIgnoreStart
            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FILE__ . ':' . __LINE__ . ':' . __FUNCTION__ . ':' .
                'Deleting queued job for updating Todo search index due to max attempt reached', [
                'queue'           => $this->queue,
                'attempts'        => $attempts,
                'next_retry_time' => $next_retry_time,
                'retry_limit'     => $retry_limit
            ]);

            $this->delete();
            return;
        } // @codeCoverageIgnoreEnd

        try {
            if ($this->action == 'insert') {
                $todoRepository->addSearchIndex($this->todo);
            } elseif ($this->action == 'update') {
                $todoRepository->updateSearchIndex($this->todo);
            } elseif ($this->action == 'delete') {
                $todoRepository->deleteSearchIndex($this->todo);
            }

            // Clear user's Todos caches
            $cache->forget('todoSearchByUserId_' . $this->todo->user_id);

            AppLog::debug(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                'Elasticsearch queued event update index document successfully executed', [
                'todo_id' => $this->todo->id,
                'action'  => $this->action
            ]);
        } catch (\Exception $e) { // @codeCoverageIgnoreStart
            AppLog::warning(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                'Queued job add todo to search index failed to run. Will try again', [
                'queue'           => $this->queue,
                'attempts'        => $attempts,
                'next_retry_time' => $next_retry_time,
                'retry_limit'     => $retry_limit
            ]);

            $this->release($next_retry_time);
            return;
        } // @codeCoverageIgnoreEnd
    }
}
