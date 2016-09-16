<?php

namespace App\Exceptions;

use App\Models\AppLog;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        MethodNotAllowedHttpException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->responseError('Method not allowed', 'The requested method supplied is not allowed', 40501004, 405);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->responseError('No such endpoint found',
                'Missing or invalid API Endpoint requested. Please check your syntax', 40401005, 404);
        }

        $parent_e = get_parent_class($e);
        if ($parent_e == 'League\OAuth2\Server\Exception\OAuthException') {
            $statusCode = !empty($e->httpStatusCode) ? $e->httpStatusCode : 401;
            $errorTitle = !empty($e->errorType) ? $e->errorType : 'error';
            return $this->responseError($errorTitle, $e->getMessage(), $statusCode, $statusCode);
        }

        if (app()->isDownForMaintenance()) {
            return $this->responseError('Be right back', 'The service is temporary down for maintenance', 50300000, 503);
        }

        return parent::render($request, $e);
    }
}
