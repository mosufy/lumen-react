<?php
/**
 * Class IPAddressHelper
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Helpers;

use App\Models\AppLog;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class IPAddressHelper
 *
 * Contains static helper methods related to IP Addresses.
 *
 * ### Example Usage
 * ```
 * Class ApiLogRepository
 * {
 *      use \App\Traits\IpAddressTrait;
 * }
 * ```
 */
class IPAddressHelper
{
    /**
     * Get client ip address
     *
     * Get actual client ip with respect to proxies and forwarded ips.
     *
     * @return string
     */
    public static function getClientIpAddress() // @codeCoverageIgnoreStart
    {
        $trustedProxies    = env('TRUSTED_PROXIES');
        $trustedProxiesArr = explode(',', $trustedProxies);

        // Set the trusted proxies so that it does not get returned on $request->getClientIp()
        Request::setTrustedProxies($trustedProxiesArr);

        return Request::getClientIp();
    } // @codeCoverageIgnoreEnd

    /**
     * Get client hostname
     *
     * Get client hostname by ip address.
     *
     * @param string $ip_address
     * @return string
     */
    public static function getClientHostname($ip_address)
    {
        $key    = 'hostname_byIP';
        $expire = 30;
        $data   = [];

        if (Cache::has($key)) {
            $data = Cache::get($key);
            if (array_key_exists($ip_address, $data)) {
                return $data[$ip_address];
            }
        } // @codeCoverageIgnore

        $data[$ip_address] = gethostbyaddr($ip_address);

        Cache::put($key, $data, $expire);

        return $data[$ip_address];
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
    public static function getGeoIP($ip_address)
    {
        try {
            $key    = 'geoIP_byIP';
            $expire = 1440; // 24 hours
            $data   = [];

            if (Cache::has($key)) {
                $data = Cache::get($key);
                if (array_key_exists($ip_address, $data)) {
                    return $data[$ip_address];
                }
            } // @codeCoverageIgnore

            $client = new Client();
            $res    = $client->get('http://freegeoip.net/json/' . $ip_address);
            $result = json_decode($res->getBody(), true);

            $data[$ip_address] = $result;
            Cache::put($key, $data, $expire);

            return $data[$ip_address];
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
    public static function getIPCountry($ip_address)
    {
        $geoIP = static::getGeoIP($ip_address);

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
    public static function getIPCountryCode($ip_address)
    {
        $geoIP = static::getGeoIP($ip_address);

        if (!empty($geoIP['country_code'])) {
            return $geoIP['country_code'];
        }

        return '';
    }
}
