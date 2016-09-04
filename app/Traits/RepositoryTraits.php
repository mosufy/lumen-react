<?php
/**
 * Class RepositoryTraits
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Traits;

use App\Helpers\CommonHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Trait RepositoryTrait
 *
 * Contains common methods used in Repositories.
 */
trait RepositoryTraits
{
    /**
     * Get limit from request parameters
     *
     * @param array $params
     * @return int
     */
    protected function getLimit($params)
    {
        return !empty($params['limit']) ? $params['limit'] : 25;
    }

    /**
     * Get page from request parameters
     *
     * @param array $params
     * @return int
     */
    protected function getPage($params)
    {
        return !empty($params['page']) ? $params['page'] : 1;
    }

    /**
     * Get offset from request parameters
     *
     * @param array $params
     * @return int
     */
    protected function getOffset($params)
    {
        $page  = $this->getPage($params);
        $limit = $this->getLimit($params);

        return (($page - 1) * $limit);
    }

    /**
     * Get path
     *
     * @return mixed
     */
    protected function getPath()
    {
        return Request::url();
    }

    /**
     * Generate paginated data
     *
     * @param mixed $object
     * @param array $params
     * @return LengthAwarePaginator
     */
    protected function getPaginated($object, $params)
    {
        $params = CommonHelper::unsetInternalParams($params);

        $params['page']  = $this->getPage($params);
        $params['limit'] = $this->getLimit($params);
        $offset          = $this->getOffset($params);
        $path            = $this->getPath();

        // Fetch the scoped data
        $result = $object->skip($offset)->limit($params['limit'])->get();

        // Get total count
        $total_count = $object->select(DB::raw('count(*) as count'))->value('count');

        // Generate paginator
        $paginated = new LengthAwarePaginator($result, $total_count, $params['limit'], $params['page'], ['path' => $path]);
        $paginated = $paginated->appends($params);

        return $paginated;
    }
}