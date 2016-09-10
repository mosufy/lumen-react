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
use App\Events\TodoDeleted;
use App\Events\TodoUpdated;
use App\Exceptions\TodoException;
use App\Models\AppLog;
use App\Models\Todo;
use App\Services\ElasticsearchService;
use App\Traits\RepositoryTraits;
use Illuminate\Pagination\LengthAwarePaginator;
use Nord\Lumen\Elasticsearch\Contracts\ElasticsearchServiceContract;
use Ramsey\Uuid\Uuid;

/**
 * Class TodoRepository
 *
 * To-Do methods.
 */
class TodoRepository
{
    use RepositoryTraits;

    /**
     * Get todos
     *
     * @param \App\Models\User $user
     * @param array            $params
     * @return mixed
     */
    public function getTodos($user, $params)
    {
        if (!empty($params['q'])) {
            return $this->getTodosBySearch($params, $user);
        }

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
     * @throws TodoException
     */
    public function getTodoByUid($todo_uid, $user)
    {
        $todo = Todo::where('uid', $todo_uid)->where('user_id', $user->id)->first();

        if (empty($todo)) {
            AppLog::warning(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                'Todo not found', [
                'todo_uid' => $todo_uid,
                'user_id'  => $user->id
            ]);
            throw new TodoException('Todo not found', 40400000);
        }

        return $todo;
    }

    /**
     * Get todos by search query
     *
     * @param array            $params
     * @param \App\Models\User $user
     * @return LengthAwarePaginator
     */
    public function getTodosBySearch($params, $user)
    {
        $res = $this->searchTodo($params, $user);

        $key    = 'todoSearchByUserId_' . $user->id;
        $subKey = json_encode($res);

        if ($cached = $this->getCache($key, $subKey)) {
            return $cached;
        }

        // Get results from Elasticsearch
        $search = $this->searchTodo($params, $user);

        // Get actual response using the returned ids from Elasticsearch
        $todos = Todo::whereIn('id', $search['ids']);

        // Get paginated data
        $paginated = $this->getPaginated($todos, $params, $search['total'], true);

        $this->putCache($key, $paginated, 30, $subKey);

        return $paginated;
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
            $todo->uid         = Uuid::uuid4()->toString();
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
        } catch (TodoException $e) {
            AppLog::debug(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                get_class($e), [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'file'     => $e->getFile(),
                'line'     => $e->getLine(),
                'todo_uid' => $todo_uid,
                'user_id'  => $user->id,
                'params'   => $params
            ]);
            throw $e;
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

    /**
     * Delete existing Todos
     *
     * @param string           $todo_uid
     * @param \App\Models\User $user
     * @throws TodoException
     * @return null
     */
    public function deleteTodo($todo_uid, $user)
    {
        try {
            $todo = $this->getTodoByUid($todo_uid, $user);
            $todo->delete();

            event(new TodoDeleted($todo));

            return null;
        } catch (TodoException $e) {
            AppLog::debug(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                get_class($e), [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'file'     => $e->getFile(),
                'line'     => $e->getLine(),
                'todo_uid' => $todo_uid,
                'user_id'  => $user->id
            ]);
            throw $e;
        } catch (\Exception $e) {
            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                get_class($e), [
                'message'  => $e->getMessage(),
                'code'     => $e->getCode(),
                'file'     => $e->getFile(),
                'line'     => $e->getLine(),
                'todo_uid' => $todo_uid,
                'user_id'  => $user->id
            ]);
            throw new TodoException('Exception thrown while trying to delete todo', 50001001);
        }
    }

    /**
     * Search todos by Elasticsearch
     *
     * @param array            $params
     * @param \App\Models\User $user
     * @return array
     * @throws TodoException
     */
    protected function searchTodo($params, $user = null)
    {
        $limit = !empty($params['limit']) ? (int)$params['limit'] : 25;
        $page  = !empty($params['page']) ? (int)$params['page'] : 1;

        $user_id = !empty($user) ? (int)$user->id : '';

        $uid = !empty($params['uid']) ? $params['uid'] : '';
        $q   = !empty($params['q']) ? $params['q'] : '';

        $category_ids = [];
        if (!empty($params['category_id'])) {
            $category_ids[] = (int)$params['category_id'];
        }

        if (!empty($params['category_ids'])) {
            $categoryIdArr = explode(',', $params['category_ids']);
            $category_ids  = [];
            foreach ($categoryIdArr as $k) {
                $category_ids[] = (int)$k;
            }
        }

        $parameters = [
            'index' => 'todo_index',
            'type'  => 'todo_type',
            'body'  => [
                'query' => [
                    'filtered' => [ // This is a filtered query
                        'query'  => [ // Query allow for a matched score search
                            'multi_match' => [
                                'query'     => $q,
                                'fuzziness' => 'AUTO',
                                'fields'    => ['uid', 'title', 'description', 'category_name'],
                            ]
                        ],
                        'filter' => [ // Filter allow for a much faster query as it does not need to be scored
                            'bool' => [
                                'must' => [
                                    [
                                        'term' => [
                                            'user_id' => $user_id
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        if (!empty($uid)) {
            $parameters['body']['query']['filtered']['filter']['bool']['must'][] = [
                'term' => [
                    'uid' => $uid
                ]
            ];
        }

        if (!empty($category_ids)) {
            $parameters = array_merge_recursive($parameters, [
                'body' => [
                    'query' => [
                        'filtered' => [
                            'filter' => [
                                'bool' => [
                                    'should' => [
                                        'terms' => [
                                            'category_id' => $category_ids
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
        }

        // Add pagination
        $parameters['size'] = $limit;
        $parameters['from'] = ($page - 1) * $limit;

        try {
            $elastic = app(ElasticsearchService::class);
            $res     = $elastic->search($parameters);
        } catch (\Exception $e) {
            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                get_class($e), [
                'message'        => $e->getMessage(),
                'code'           => $e->getCode(),
                'file'           => $e->getFile(),
                'line'           => $e->getLine(),
                'dql_parameters' => $parameters,
                'params'         => $params,
                'user_id'        => $user->id
            ]);
            throw new TodoException('Elasticsearch exception thrown while search todo', 50001001);
        }

        AppLog::debug(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
            'Elasticsearch response', [
            'dql_parameters' => $parameters,
            'params'         => $params,
            'user_id'        => $user->id,
            'response'       => $res
        ]);

        if ($res['hits']['total'] > 0) {
            $ids = [];
            foreach ($res['hits']['hits'] as $k => $v) {
                $ids[] = (int)$v['_id'];
            }

            return [
                'total' => $res['hits']['total'],
                'ids'   => $ids
            ];
        }

        return [
            'total' => 0,
            'ids'   => []
        ];
    }
}
