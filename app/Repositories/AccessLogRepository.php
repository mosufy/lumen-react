<?php
/**
 * Class AccessLogRepository
 *
 * @date      1/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Repositories;

use App\Models\AccessLog;
use App\Models\AppLog;
use App\Traits\IPAddressTrait;
use LucaDegasperi\OAuth2Server\Authorizer;
use Jenssegers\Agent\Agent;

/**
 * Class AccessLogRepository
 */
class AccessLogRepository
{
    use IPAddressTrait;

    protected $authorizer, $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    /**
     * Insert into accesslogs table
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Illuminate\Http\Response $response
     * $return void
     */
    public function createLog($request, $response)
    {
        if (env('ACCESSLOG_SWITCH') != 'on' || app()->environment('testing')) {
            return;
        }

        // @codeCoverageIgnoreStart

        $authorizer = app(Authorizer::class);

        $client_id    = $authorizer->getClientId();
        $owner_type   = $authorizer->getResourceOwnerType();
        $owner_id     = ($owner_type == 'client') ? null : $authorizer->getResourceOwnerId();
        $access_token = $authorizer->getAccessToken();

        $endpoint       = '/' . $request->path();
        $method         = $request->method();
        $status_code    = $response->getStatusCode();
        $request_string = json_encode($request->except('_url', '_token', 'password'));
        $response       = $response->getContent();

        try {
            $ip_address      = $this->getClientIpAddress();
            $ip_country      = $this->getIPCountry($ip_address);
            $ip_country_code = $this->getIPCountryCode($ip_address);
            $hostname        = $this->getClientHostname($ip_address);
        } catch (\Exception $e) {
            AppLog::warning(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                'Failed to fetch ip address fields', [
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine()
            ]);
        }

        $platform         = $this->agent->isTablet() ? 'tablet' : ($this->agent->isMobile() ? 'mobile' : 'desktop');
        $device           = $this->agent->device();
        $browser          = $this->agent->browser();
        $browser_version  = $this->agent->version($browser);
        $browser_language = json_encode($this->agent->languages());
        $os               = $this->agent->platform();
        $os_version       = $this->agent->version($os);

        try {
            $accessLog                   = new AccessLog;
            $accessLog->client_id        = $client_id;
            $accessLog->owner_type       = $owner_type;
            $accessLog->owner_id         = $owner_id;
            $accessLog->endpoint         = $endpoint;
            $accessLog->method           = $method;
            $accessLog->status_code      = $status_code;
            $accessLog->request          = $request_string;
            $accessLog->response         = $response;
            $accessLog->access_token     = $access_token;
            $accessLog->ip_address       = isset($ip_address) ? $ip_address : '';
            $accessLog->ip_country       = isset($ip_country) ? $ip_country : '';
            $accessLog->ip_country_code  = isset($ip_country_code) ? $ip_country_code : '';
            $accessLog->hostname         = isset($hostname) ? $hostname : '';
            $accessLog->platform         = $platform;
            $accessLog->device           = $device;
            $accessLog->browser          = $browser;
            $accessLog->browser_version  = $browser_version;
            $accessLog->browser_language = $browser_language;
            $accessLog->os               = $os;
            $accessLog->os_version       = $os_version;
            $accessLog->save();
        } catch (\Exception $e) {
            AppLog::warning(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                'Failed to write to accesslogs db', [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'request' => $request
            ]);
        }
    } // @codeCoverageIgnoreEnd
}
