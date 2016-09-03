<?php
/**
 * Class SendMailer
 *
 * @date      3/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Jobs;

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
        $mailType = $this->mailType;

        $mailRepository->$mailType($this->user);
    }
}
