<?php
/**
 * Class MailRepository
 *
 * @date      3/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Repositories;

use App\Models\AppLog;
use Illuminate\Support\Facades\Mail;

/**
 * Class MailRepository
 *
 * Sends various emails.
 */
class MailRepository
{
    public function activationEmail($user)
    {
        $this->sendMail($user, 'emails.activation', 'Activate your account!', 'activation');
    }

    /**
     * @param \App\Models\User $user
     * @param string           $template
     * @param string           $subject
     * @param string           $tag
     * @param string           $from
     * @param string           $from_name
     * @throws \Exception
     */
    protected function sendMail($user, $template, $subject, $tag = '', $from = 'hello@app.com', $from_name = 'My app')
    {
        try {
            Mail::send($template, ['user' => $user], function ($m) use ($user, $subject, $tag, $from, $from_name) {
                $m->from($from, $from_name);
                $m->to($user->email, $user->name)->subject($subject);

                // tag this email for segmentation
                if (!empty($tag)) {
                    $headers = $m->getHeaders();
                    $headers->addTextHeader('X-Mailgun-Tag', $tag);
                }
            });
        } catch (\Exception $e) {
            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                get_class($e), [
                'message'    => $e->getMessage(),
                'code'       => $e->getCode(),
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
                'user_email' => $user->email,
                'template'   => $template,
                'subject'    => $subject,
                'tag'        => $tag,
                'from'       => $from,
                'from_name'  => $from_name
            ]);

            throw $e;
        }
    }
}
