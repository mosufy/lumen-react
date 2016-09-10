<?php
/**
 * Class TodoEventSubscriber
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Listeners;

use App\Events\TodoCreated;
use App\Events\TodoDeleted;
use App\Events\TodoUpdated;
use App\Jobs\UpdateTodoSearchIndex;
use App\Models\AppLog;
use App\Repositories\TodoRepository;
use Illuminate\Contracts\Cache\Repository as Cache;

/**
 * Class TodoEventSubscriber
 *
 * Subscribes to Todos events.
 */
class TodoEventSubscriber
{
    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Handle todos created events.
     *
     * @param TodoCreated $event
     */
    public function onTodoCreated($event)
    {
        // Add to Elasticsearch index
        dispatch((new UpdateTodoSearchIndex($event->todo, 'insert'))->onQueue('default'));

        // Clear user's Todos caches
        $this->cache->forget('todosByUserId_' . $event->todo->user_id);
    }

    /**
     * Handle todos updated events.
     *
     * @param TodoUpdated $event
     */
    public function onTodoUpdated($event)
    {
        // Add to Elasticsearch index
        dispatch((new UpdateTodoSearchIndex($event->todo, 'update'))->onQueue('default'));

        // Clear user's Todos caches
        $this->cache->forget('todosByUserId_' . $event->todo->user_id);
    }

    /**
     * Handle todos deleted events.
     *
     * @param TodoDeleted $event
     */
    public function onTodoDeleted($event)
    {
        // Delete search index
        dispatch((new UpdateTodoSearchIndex($event->todo, 'delete'))->onQueue('default'));

        /*
         * FIXME: Deleting queued job above does not seem to work. Will have to re-look into this.
         */
        $todoRepository = new TodoRepository();
        $todoRepository->deleteSearchIndex($event->todo);
        $this->cache->forget('todoSearchByUserId_' . $event->todo->user_id);
        AppLog::debug(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
            'Elasticsearch index deleted successfully', [
            'todo_id' => $event->todo->id,
            'action'  => 'delete'
        ]);

        // Clear user's Todos caches
        $this->cache->forget('todosByUserId_' . $event->todo->user_id);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        // @codeCoverageIgnoreStart
        $events->listen(
            'App\Events\TodoCreated',
            'App\Listeners\TodoEventSubscriber@onTodoCreated'
        );

        $events->listen(
            'App\Events\TodoUpdated',
            'App\Listeners\TodoEventSubscriber@onTodoUpdated'
        );

        $events->listen(
            'App\Events\TodoDeleted',
            'App\Listeners\TodoEventSubscriber@onTodoDeleted'
        );
        // @codeCoverageIgnoreEnd
    }
}
