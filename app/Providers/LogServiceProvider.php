<?php
/**
 * Class LogServiceProvider
 *
 * @date      27/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\HandlerWrapper;
use Monolog\Handler\RotatingFileHandler;

/**
 * Class LogServiceProvider
 *
 * Replace lumen's native monolog config.
 */
class LogServiceProvider extends ServiceProvider
{
    /**
     * Boot the logger interface
     *
     * @return void
     */
    public function boot()
    {
        if (!app()->environment('testing')) {
            app('Psr\Log\LoggerInterface')->setHandlers([$this->getRotatingLogHandler()]);
        }
    }

    /**
     * Allow lumen to log as daily log
     *
     * @param int $maxFiles
     * @return \Monolog\Handler\HandlerInterface
     */
    public function getRotatingLogHandler($maxFiles = 7)
    {
        return (new RotatingFileHandler(storage_path('logs/lumen.log'), $maxFiles))
            ->setFormatter(new LineFormatter(null, null, true, true));
    }

    /**
     * Register any application services
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
