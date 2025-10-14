<?php

declare(strict_types = 1);

namespace App\Modules\Users\Jobs;

use App\Modules\BaseNotification\NotifierFactory\NotifierFactory;
use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendActivationCode implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user, public $notificationData = [])
    {
    }


    public function handle()
    {
        $this->generateOtp();
        if ($this->user->otp) {
            $this->sendNotification(data: $this->notificationData);
        }
    }

    private function generateOtp(): void
    {
        $otp = (string)rand(1000, 9999);
        $isExists = (new UserRepository())->findByCol('otp', $otp);

        if ($isExists) {
            $this->generateOtp();
        }
        $this->user->otp = $otp;
        $this->user->save();
    }

    private function sendNotification($data)
    {
        if (isset($data['sms'])) {
            $notificationData = [
                'users' => $data['users'],
                'sms' => [
                    'message' => trans(
                        $data['sms']['message'],
                        [
                            'otp' => $this->user->otp,
                        ],
                        $this->user->language
                    ),
                ],
            ];
            (new NotifierFactory())->send($notificationData);
        }

        if (isset($data['email'])) {
            $notificationData = [
                'users' => $data['users'],
                'mail' => [
                    'user_type' => isset($data['email']['user_type']) ? $data['email']['user_type'] : 'student',
                    'data' => array_merge(
                        $data['email']['data'],
                        ['code' => $this->user->otp, 'lang' => $this->user->language]
                    ),
                    'view' => isset($data['email']['view']) ? $data['email']['view'] : 'otp_template',
                    'subject' => $data['email']['subject'],
                ],
            ];

            (new NotifierFactory())->send($notificationData);
        }
    }
}
