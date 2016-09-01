<?php
/**
 * Class AccessLogMiddleware
 *
 * @date      1/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Middleware;

use App\Repositories\AccessLogRepository;
use Closure;

/**
 * Class AccessLogMiddleware
 *
 * Writes to access log after every request.
 */
class AccessLogMiddleware
{
    protected $accessLogRepository;

    public function __construct(AccessLogRepository $accessLogRepository)
    {
        $this->accessLogRepository = $accessLogRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * Handle after response is sent
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response $response
     * @return mixed
     */
    public function terminate($request, $response)
    {
        $this->accessLogRepository->createLog($request, $response);
    }
}
