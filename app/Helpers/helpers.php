<?php // Custom Helper functions. These helper functions get auto loaded on composer.

/**
 * Unset internal parameters
 *
 * @param array $params
 * @return array
 */
function unsetInternalParams($params)
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
function unsetPaginationParams($params)
{
    unset($params['page']);
    unset($params['limit']);

    return $params;
}
