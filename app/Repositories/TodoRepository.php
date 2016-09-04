<?php
/**
 * Class TodoRepository
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Repositories;

use App\Events\TodoCreated;
use App\Events\TodoUpdated;
use App\Exceptions\TodoException;
use App\Models\AppLog;
use App\Models\Todo;
use App\Traits\RepositoryTraits;
use Webpatser\Uuid\Uuid;

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
        $key    = 'todosByUserId_' . $user->id;
        $subKey = json_encode($params);

        if ($cached = $this->getCache($key, $subKey)) {
            return $cached;
        }

        $todos = Todo::where('user_id', $user->id);

        // Get paginated data
        $paginated = $this->getPaginated($todos, $params);

        $this->putCache($key, $paginated, 30, $subKey);

        return $paginated;
    }

    /**
     * Get todos by uid
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

    /**
     * Create new Todos
     *
     * @param \App\Models\User $user
     * @param array            $params
     * @throws TodoException
     * @return Todo
     */
    public function createTodo($user, $params)
    {
        try {
            $todo              = new Todo;
            $todo->uid         = (string)Uuid::generate(4);
            $todo->title       = $params['title'];
            $todo->description = $params['description'];
            $todo->category_id = $params['category_id'];
            $todo->user_id     = $user->id;
            $todo->save();

            event(new TodoCreated($todo));

            return $todo;
        } catch (\Exception $e) {
            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                get_class($e), [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'user_id' => $user->id,
                'params'  => $params
            ]);
            throw new TodoException('Exception thrown while trying to create todo', 50001001);
        }
    }

    /**
     * Update existing Todos
     *
     * @param string           $todo_uid
     * @param \App\Models\User $user
     * @param array            $params
     * @throws TodoException
     * @return Todo
     */
    public function updateTodo($todo_uid, $user, $params)
    {
        try {
            $todo              = $this->getTodoByUid($todo_uid, $user);
            $todo->title       = $params['title'];
            $todo->description = $params['description'];
            $todo->category_id = $params['category_id'];
            $todo->save();

            event(new TodoUpdated($todo));

            return $todo;
        } catch (\Exception $e) {
            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                get_class($e), [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'file'     => $e->getFile(),
                'line'     => $e->getLine(),
                'todo_uid' => $todo_uid,
                'user_id'  => $user->id,
                'params'   => $params
            ]);
            throw new TodoException('Exception thrown while trying to update todo', 50001001);
        }
    }
}
