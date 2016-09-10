<?php
/**
 * Class ResponseTrait
 *
 * @date      26/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Traits;

use App\Helpers\CommonHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Trait ResponseTrait
 *
 * Contains methods to generate API Responses.
 */
trait ResponseTrait
{
    /**
     * Return single data success response
     *
     * @param string $type
     * @param array  $data
     * @param array  $extra
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function responseSuccess($type = '', $data = [], $extra = [])
    {
        if ($data instanceof LengthAwarePaginator) {
            return $this->responsePaginate($type, $data, $extra);
        }

        $jsonapi = [];

        $params = CommonHelper::unsetInternalParams($this->getRequest()->all());

        if ($this->getRequest()->method() == 'GET' && !empty($params)) {
            $jsonapi['meta'] = [
                'filter' => $params
            ];
        }

        if (is_array($data)) {
            // Array data responses
            if (!empty($data)) {
                if (!isset($data[0])) {
                    $return_data[0] = $data;
                } else {
                    $return_data = $data;
                }

                foreach ($return_data as $index => $data) {
                    $id = !empty($data['id']) ? $data['id'] : null;

                    if (!is_null($id)) {
                        unset($data[$index]['id']);
                    }

                    $jsonapi['data'][] = [
                        'type'       => $type,
                        'id'         => $id,
                        'attributes' => $return_data[$index]
                    ];
                }
            } else {
                $jsonapi = ['data' => []];
            }
        } else {
            if ($data instanceof Collection) {
                // Laravel Collection
                if ($data->count() >= 1) {
                    foreach ($data as $k) {
                        $jsonapi['data'][] = [
                            'type'       => $type,
                            'id'         => $k['id'],
                            'attributes' => $k
                        ];
                    }
                } else {
                    $jsonapi['data'][] = [
                        'type'       => $type,
                        'id'         => null,
                        'attributes' => $data
                    ];
                }
            } elseif ($data instanceof Model) {
                // Laravel Model
                $jsonapi['data'][] = [
                    'type'       => $type,
                    'id'         => $data['id'],
                    'attributes' => $data
                ];
            } else {
                // Unknown
                $jsonapi['data'][] = [
                    'type'       => $type,
                    'id'         => null,
                    'attributes' => $data
                ];
            }
        }

        return response()->json($jsonapi);
    }

    /**
     * Return error response
     *
     * @param string  $title
     * @param string  $detail
     * @param string  $code
     * @param integer $status
     * @param array   $metadata
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function responseError($title = '', $detail = '', $code = '', $status = null, $metadata = [])
    {
        $status = (int)$code > 0 ? substr($code, 0, 3) : $status;

        // Our error code consists of <http status code> + <module code> + <incremental id>.
        // Thus, we will take the first 3 digits of our error code to form the HTTP status code to return as response.
        $valid_http_error_response_code = ["400", "401", "403", "404", "405", "500"];

        if (!in_array($status, $valid_http_error_response_code)) {
            $status = 500;
        }

        // json decode string if it is json string
        if (is_array($detail2 = json_decode($detail, true))) {
            $detail = $detail2;
        }

        $jsonapi['errors'] = [
            array_merge([
                'status' => (int)$status,
                'code'   => $code,
                'source' => '/' . $this->getRequest()->path(),
                'title'  => $title,
                'detail' => $detail
            ], $metadata)
        ];

        return response()->json($jsonapi, $status);
    }

    /**
     * Return paginated response
     *
     * @param string               $type
     * @param LengthAwarePaginator $data
     * @param array                $extra
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function responsePaginate($type, $data, $extra = [])
    {
        $data = $data->toArray();

        $jsonapi['meta'] = [
            'filter' => CommonHelper::unsetInternalParams($this->getRequest()->all())
        ];

        if (!empty($data['data'])) {
            foreach ($data['data'] as $k) {
                $jsonapi['data'][] = [
                    'type'       => $type,
                    'id'         => !empty($k['id']) ? $k['id'] : null,
                    'attributes' => $k
                ];
            }
        } else {
            $jsonapi['data'] = [];
        }

        // Remove data to get meta
        unset($data['data']);

        $jsonapi['meta'] = array_merge($jsonapi['meta'], $data);

        return response()->json($jsonapi);
    }

    /**
     * Get current request
     *
     * @return Request
     */
    protected function getRequest()
    {
        return app('request');
    }
}