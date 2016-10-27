<?php
/**
 * Class TodoController
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Controllers;

use App\Repositories\TodoRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

/**
 * Class TodoController
 *
 * To-Do resource endpoints.
 */
class TodoController extends Controller
{
    protected $todoRepository, $userRepository;

    public function __construct(TodoRepository $todoRepository, UserRepository $userRepository)
    {
        $this->todoRepository = $todoRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Get all todos
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        try {
            $user  = $this->userRepository->getCurrentUser();
            $todos = $this->todoRepository->getTodos($user, $request->all());

            return $this->responseSuccess('todo', $todos);
        } catch (\Exception $e) { // @codeCoverageIgnoreStart
            return $this->responseError('Failed to fetch all todos', $e->getMessage(), $e->getCode());
        } // @codeCoverageIgnoreEnd
    }

    /**
     * Get todos by uid
     *
     * @param string $todo_uid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($todo_uid)
    {
        try {
            $user = $this->userRepository->getCurrentUser();
            $todo = $this->todoRepository->getTodoByUid($todo_uid, $user);

            return $this->responseSuccess('todo', $todo);
        } catch (\Exception $e) {
            return $this->responseError('Failed to fetch todo', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Insert Todos
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        try {
            $user = $this->userRepository->getCurrentUser();
            $todo = $this->todoRepository->createTodo($user, $request->all());

            return $this->responseSuccess('todo', $todo);
        } catch (\Exception $e) {
            return $this->responseError('Failed to insert todo', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update existing Todos
     *
     * @param Request $request
     * @param string  $todo_uid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, $todo_uid)
    {
        try {
            $user = $this->userRepository->getCurrentUser();
            $todo = $this->todoRepository->updateTodo($todo_uid, $user, $request->all());

            return $this->responseSuccess('todo', $todo);
        } catch (\Exception $e) {
            return $this->responseError('Failed to update todo', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update existing Todos
     *
     * @param Request $request
     * @param string  $todo_uid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toggle(Request $request, $todo_uid)
    {
        try {
            $user = $this->userRepository->getCurrentUser();
            $todo = $this->todoRepository->toggleTodo($todo_uid, $user);

            return $this->responseSuccess('todo', $todo);
        } catch (\Exception $e) {
            return $this->responseError('Failed to toggle todo', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Delete Todos
     *
     * @param string $todo_uid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy($todo_uid)
    {
        try {
            $user = $this->userRepository->getCurrentUser();
            $todo = $this->todoRepository->deleteTodo($todo_uid, $user);

            return $this->responseSuccess('todo', $todo);
        } catch (\Exception $e) {
            return $this->responseError('Failed to delete todo', $e->getMessage(), $e->getCode());
        }
    }
}
