<?php
/**
 * Class TodoCreated
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Events;

use App\Models\Todo;
use Illuminate\Queue\SerializesModels;

/**
 * Class TodoCreated
 *
 * Todos created event.
 */
class TodoCreated extends Event
{
    use SerializesModels;

    public $todo;

    /**
     * Create a new event instance.
     *
     * @param Todo $todo
     */
    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }
}
