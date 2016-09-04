<?php
/**
 * Class TodoController
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Repositories\TodoRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

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
            $todos = $this->todoRepository->getAllTodos($user, $request->all());

            return $this->responseSuccess('todo', $todos);
        } catch (\Exception $e) {
            return $this->responseError('Failed to fetch all todos', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Get todos by uid
     *
     * @param Request $request
     * @param string  $todo_uid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request, $todo_uid)
    {
        try {
            $user = $this->userRepository->getCurrentUser();
            $todo = $this->todoRepository->getTodoByUid($todo_uid, $user);

            return $this->responseSuccess('todo', $todo);
        } catch (\Exception $e) {
            return $this->responseError('Failed to fetch todo', $e->getMessage(), $e->getCode());
        }
    }
}
