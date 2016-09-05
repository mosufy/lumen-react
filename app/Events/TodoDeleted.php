<?php
/**
 * Class TodoDeleted
 *
 * @date      5/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Events;

use App\Models\Todo;
use Illuminate\Queue\SerializesModels;

/**
 * Class TodoDeleted
 *
 * Todos deleted event.
 */
class TodoDeleted extends Event
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
