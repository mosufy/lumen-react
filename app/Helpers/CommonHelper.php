<?php
/**
 * Class CommonHelper
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Helpers;

/**
 * Class CommonHelper
 *
 * Common helper methods.
 */
class CommonHelper
{
    /**
     * Unset internal parameters
     *
     * @param array $params
     * @return array
     */
    public static function unsetInternalParams($params)
    {
        unset($params['_url']);
        unset($params['_token']);
        unset($params['_method']);

        return $params;
    }

    /**
     * Unset pagination parameters
     *
     * @param array $params
     * @return array
     */
    public static function unsetPaginationParams($params)
    {
        unset($params['page']);
        unset($params['limit']);

        return $params;
    }
}
