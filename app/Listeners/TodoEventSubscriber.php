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
use Illuminate\Support\Facades\Cache;

/**
 * Class TodoEventSubscriber
 *
 * Subscribes to Todos events.
 */
class TodoEventSubscriber
{
    /**
     * Handle user created events.
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
    }
}
