<?php
/**
 * Class UserCreated
 *
 * @date      3/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserCreated
 *
 * User created event.
 */
class UserCreated extends Event
{
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
