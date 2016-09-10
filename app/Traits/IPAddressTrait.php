<?php
/**
 * Class IPAddressTrait
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Traits;

use App\Models\AppLog;
use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository as Cache;

/**
 * Class IPAddressTrait
 *
 * Contains helper methods related to IP Addresses.
 *
 * ### Example Usage
 * ```
 * Class ApiLogRepository
 * {
 *      use \App\Traits\IpAddressTrait;
 * }
 * ```
 */
trait IPAddressTrait
{
    /**
     * Get client ip address
     *
     * Get actual client ip with respect to proxies and forwarded ips.
     *
     * @return string
     */
    public function getClientIpAddress() // @codeCoverageIgnoreStart
    {
        $trustedProxies    = env('TRUSTED_PROXIES', '10.1.2.100');
        $trustedProxiesArr = explode(',', $trustedProxies);

        // Set the trusted proxies so that it does not get returned on $request->getClientIp()
        $this->getRequest()->setTrustedProxies($trustedProxiesArr);

        return $this->getRequest()->getClientIp();
    } // @codeCoverageIgnoreEnd

    /**
     * Get client hostname
     *
     * Get client hostname by ip address.
     *
     * @param string $ip_address
     * @return string
     */
    public function getClientHostname($ip_address)
    {
        if (!is_string($ip_address)) {
            return '';
        }

        $key    = 'hostname_byIP';
        $subKey = is_string($ip_address) ? str_slug($ip_address) : '';
        $expire = 30;
        $data   = [];

        if ($this->getCacheObject()->has($key)) {
            $data = $this->getCacheObject()->get($key);
            if (array_key_exists($subKey, $data)) {
                return $data[$subKey];
            }
        } // @codeCoverageIgnore

        try {
            $data[$subKey] = gethostbyaddr($ip_address);
        } catch (\Exception $e) {
            // do nothing
        }

        $this->getCacheObject()->put($key, $data, $expire);

        return $data[$subKey];
    }

    /**
     * Get geoIP by ip address
     *
     * Using freegeoip service to fetch geoIP data by ip address.
     *
     * ### Sample response
     * ```
     * {
     *      "ip":"43.240.14.99",
     *      "country_code":"HK",
     *      "country_name":"Hong Kong",
     *      "region_code":"",
     *      "region_name":"",
     *      "city":"Sha Po Kong",
     *      "zip_code":"",
     *      "time_zone":"Asia/Hong_Kong",
     *      "latitude":22.333,
     *      "longitude":114.2,
     *      "metro_code":0
     * }
     * ```
     *
     * @param string $ip_address
     * @return array
     *
     * @see https://fraeegeoip.net
     */
    public function getGeoIP($ip_address)
    {
        try {
            $key    = 'geoIP_byIP';
            $subKey = str_slug($ip_address);
            $expire = 1440; // 24 hours
            $data   = [];

            if ($this->getCacheObject()->has($key)) {
                $data = $this->getCacheObject()->get($key);
                if (array_key_exists($subKey, $data)) {
                    return $data[$subKey];
                }
            } // @codeCoverageIgnore

            $client = new Client();
            $res    = $client->get('http://freegeoip.net/json/' . $ip_address);
            $result = json_decode($res->getBody(), true);

            $data[$subKey] = $result;
            $this->getCacheObject()->put($key, $data, $expire);

            return $data[$subKey];
        } catch (\Exception $e) { // @codeCoverageIgnoreStart
            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                get_class($e), [
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
                'message'    => $e->getMessage(),
                'code'       => $e->getCode(),
                'ip_address' => $ip_address
            ]);
            return []; // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Get country name by ip address
     *
     * @param string $ip_address
     * @return string
     */
    public function getIPCountry($ip_address)
    {
        $geoIP = $this->getGeoIP($ip_address);

        if (!empty($geoIP['country_name'])) {
            return $geoIP['country_name'];
        }

        return '';
    }

    /**
     * Get country code by ip address
     *
     * @param string $ip_address
     * @return string
     */
    public function getIPCountryCode($ip_address)
    {
        $geoIP = $this->getGeoIP($ip_address);

        if (!empty($geoIP['country_code'])) {
            return $geoIP['country_code'];
        }

        return '';
    }

    /**
     * Get request object
     *
     * @return \Illuminate\Http\Request
     */
    protected function getRequest()
    {
        return app('request');
    }

    /**
     * Get Cached object
     *
     * @return Cache
     */
    protected function getCacheObject()
    {
        return app()->make(Cache::class);
    }
}
