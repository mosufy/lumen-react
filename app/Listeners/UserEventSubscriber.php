<?php
/**
 * Class UserEventSubscriber
 *
 * @date      3/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Listeners;

use App\Events\UserCreated;
use App\Jobs\SendMailer;

/**
 * Class UserEventSubscriber
 *
 * Subscribes to User events.
 */
class UserEventSubscriber
{
    /**
     * Handle user created events.
     *
     * @param UserCreated $event
     */
    public function onUserCreated($event)
    {
        // Send activation email
        dispatch((new SendMailer($event->user, 'activationEmail'))->onQueue('high'));

        // do something else
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
            'App\Events\UserCreated',
            'App\Listeners\UserEventSubscriber@onUserCreated'
        );
        // @codeCoverageIgnoreEnd
    }
}
