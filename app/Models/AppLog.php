<?php
/**
 * Class AppLog
 *
 * @date      27/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Models;

use App\Traits\IPAddressTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * AppLog model
 */
class AppLog extends Model
{
    use IPAddressTrait;

    /**
     * Set table name on database
     *
     * @var string
     */
    protected $table = 'applogs';

    /**
     * List the table columns that can be written direct
     *
     * @var array
     */
    public $fillable = ['type', 'classname', 'traitname', 'functionname', 'filename', 'linenumber', 'message', 'code', 'details',
        'ipaddr', 'createdby_user_id', 'createdby'];

    /**
     * Log message to application log
     *
     * This action will also log into lumen's native log.
     *
     * @param string $level
     * @param string $message
     * @param mixed $context
     * @return void
     */
    public static function log($level, $message, $context = [])
    {
        // Throw out debug messages if we are not in debug mode
        if (($level == 'debug') && (env('APP_DEBUG') != true)) {
            return; // @codeCoverageIgnore
        }

        // Split the log message to see how it is formatted.
        $logdata = explode(':', $message, 6);

        if (count($logdata) == 6) {
            list($classname, $traitname, $functionname, $filename, $linenumber, $exceptionMessage) = $logdata;
        } elseif (count($logdata) == 5) {
            list($classname, $traitname, $functionname, $filename, $linenumber) = $logdata;
        } else {
            list($classname, $traitname, $functionname, $filename, $linenumber, $exceptionMessage) = [
                null,
                null,
                null,
                null,
                null,
                $logdata[0]
            ];
        }

        $ipaddr = '';//static::getClientIpAddress();

        /*$api_key        = Request::header('php-auth-user');
        $createdby_user = Cache::remember('user_apiKey_' . $api_key, 30, function () use ($api_key) {
            return User::byApiKey($api_key)->first();
        });*/
        $createdby_user_id = !empty($createdby_user) ? $createdby_user->id : null;
        $createdby         = !empty($createdby_user) ? $createdby_user->name : 'system';

        // Insert into applogs table
        try {
            static::create([
                'type'              => $level,
                'classname'         => $classname,
                'traitname'         => $traitname,
                'functionname'      => $functionname,
                'filename'          => $filename,
                'linenumber'        => $linenumber,
                'message'           => !empty($exceptionMessage) ? $exceptionMessage : (!empty($context['message']) ? $context['message'] : $message),
                'code'              => !empty($context['code']) ? $context['code'] : null,
                'details'           => json_encode($context),
                'ipaddr'            => $ipaddr,
                'createdby_user_id' => $createdby_user_id,
                'createdby'         => $createdby
            ]);
        } catch(\Exception $e) {
            // Do nothing
        }

        // Add lumen log
        $log = app('log');
        $log->$level($message, $context);
    }

    /**
     * Log an emergency message to the application log.
     *
     * @param string $message
     * @param mixed $context
     * @return void
     */
    public static function emergency($message, $context = [])
    {
        static::log('emergency', $message, $context);
    }

    /**
     * Log an alert message to the application log.
     *
     * @param string $message
     * @param mixed $context
     * @return void
     */
    public static function alert($message, $context = [])
    {
        static::log('alert', $message, $context);
    }

    /**
     * Log a critical message to the application log.
     *
     * @param string $message
     * @param mixed $context
     * @return void
     */
    public static function critical($message, $context = [])
    {
        static::log('critical', $message, $context);
    }

    /**
     * Log an error message to the application log.
     *
     * @param string $message
     * @param mixed $context
     * @return void
     */
    public static function error($message, $context = [])
    {
        static::log('error', $message, $context);
    }

    /**
     * Log a warning message to the application log.
     *
     * @param string $message
     * @param mixed $context
     * @return void
     */
    public static function warning($message, $context = [])
    {
        static::log('warning', $message, $context);
    }

    /**
     * Log a notice message to the application log.
     *
     * @param string $message
     * @param mixed $context
     * @return void
     */
    public static function notice($message, $context = [])
    {
        static::log('notice', $message, $context);
    }

    /**
     * Log an info message to the application log.
     *
     * @param string $message
     * @param mixed $context
     * @return void
     */
    public static function info($message, $context = [])
    {
        static::log('info', $message, $context);
    }

    /**
     * Log a debug message to the application log.
     *
     * @param string $message
     * @param mixed $context
     * @return void
     */
    public static function debug($message, $context = [])
    {
        static::log('debug', $message, $context);
    }
}
