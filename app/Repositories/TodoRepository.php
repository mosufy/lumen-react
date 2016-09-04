<?php
/**
 * Class TodoRepository
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Repositories;

use App\Models\Todo;
use App\Traits\RepositoryTraits;
use Illuminate\Support\Facades\DB;

/**
 * Class TodoRepository
 *
 * To-Do methods.
 */
class TodoRepository
{
    use RepositoryTraits;

    /**
     * Get all todos
     *
     * @param \App\Models\User $user
     * @param array            $params
     * @return mixed
     */
    public function getAllTodos($user, $params)
    {
        $todos = Todo::where('user_id', $user->id);

        // Get total count
        $total_count = DB::table('todos')
            ->where('user_id', $user->id)
            ->select(DB::raw('count(*) as count'))->value('count');

        // Get paginated data
        $paginated = $this->getPaginated($todos, $params, $total_count);

        return $paginated;
    }

    /**
     * Get todo by uid
     *
     * @param string           $todo_uid
     * @param \App\Models\User $user
     * @return Todo
     */
    public function getTodoByUid($todo_uid, $user)
    {
        $todo = Todo::where('uid', $todo_uid)->where('user_id', $user->id)->first();

        return $todo;
    }
}
