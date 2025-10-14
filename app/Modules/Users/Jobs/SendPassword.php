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

class SendPassword implements ShouldQueue
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
            $this->sendNotification($this->notificationData);
    }



    private function sendNotification($data)
    {
        if (isset($data['sms'])) {
            $message = trans(
                $data['sms']['message'],
                [
                    'name' => $this->user->name,
                    'password' => $data['sms']['password'],
                ],
                $this->user->language
            );

            $notificationData = [
                'users' => $data['users'],
                'sms' => [
                    'message' => $message,
                ],
            ];
            (new NotifierFactory())->send($notificationData);
        }
    }
}
