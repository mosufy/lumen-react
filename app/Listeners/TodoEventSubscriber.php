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
use Illuminate\Support\Facades\Cache;

/**
 * Class TodoEventSubscriber
 *
 * Subscribes to Todos events.
 */
class TodoEventSubscriber
{
    /**
     * Handle todos created events.
     *
     * @param TodoCreated $event
     */
    public function onTodoCreated($event)
    {
        // Clear user's Todos caches
        Cache::forget('todosByUserId_' . $event->todo->user_id);

        // do something else
    }

    /**
     * Handle todos updated events.
     *
     * @param TodoUpdated $event
     */
    public function onTodoUpdated($event)
    {
        // Clear user's Todos caches
        Cache::forget('todosByUserId_' . $event->todo->user_id);

        // do something else
    }

    /**
     * Handle todos deleted events.
     *
     * @param TodoDeleted $event
     */
    public function onTodoDeleted($event)
    {
        // Clear user's Todos caches
        Cache::forget('todosByUserId_' . $event->todo->user_id);

        // do something else
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
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
    }
}
