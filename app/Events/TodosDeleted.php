<?php
/**
 * Class TodoAllDeleted
 *
 * @date      27/10/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;

/**
 * Class TodosDeleted
 *
 * Todos deleted event.
 */
class TodosDeleted extends Event
{
    use SerializesModels;

    public $todos;

    /**
     * Create a new event instance.
     *
     * @param array $todos
     */
    public function __construct($todos)
    {
        $this->todos = $todos;
    }
}
