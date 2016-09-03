<?php
/**
 * Class SendMailer
 *
 * @date      3/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Jobs;

use App\Models\AppLog;
use App\Repositories\MailRepository;

/**
 * Class SendMailer
 *
 * Job to send out emails.
 */
class SendMailer extends Job
{
    protected $user, $mailType;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\User $user
     * @param string           $mailType
     */
    public function __construct($user, $mailType)
    {
        $this->user     = $user;
        $this->mailType = $mailType;
    }

    /**
     * Execute the job.
     *
     * @param MailRepository $mailRepository
     * @return void
     */
    public function handle(MailRepository $mailRepository)
    {
        // Calculate exponential retry time
        $attempts        = $this->attempts();
        $base_sec        = 2;
        $max_sec         = 300;
        $next_retry_time = min((int)($base_sec * pow(2, $attempts - 1)), $max_sec);
        $retry_limit     = 50;

        if ($attempts > $retry_limit) {
            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FILE__ . ':' . __LINE__ . ':' . __FUNCTION__ . ':' .
                'Deleting queued job for sending email due to max attempt reached', [
                'queue'           => $this->queue,
                'attempts'        => $attempts,
                'next_retry_time' => $next_retry_time,
                'retry_limit'     => $retry_limit
            ]);

            $this->delete();
            return;
        }

        try {
            $mailType = $this->mailType;
            $mailRepository->$mailType($this->user);
        } catch (\Exception $e) {
            AppLog::warning(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                'Queued job mailer failed to run. Will try again', [
                'queue'           => $this->queue,
                'attempts'        => $attempts,
                'next_retry_time' => $next_retry_time,
                'retry_limit'     => $retry_limit
            ]);

            $this->release($next_retry_time);
            return;
        }
    }
}
