<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Arr;

class UpdateUserNotificationSettings
{
    /**
     * @var array
     */
    const FIELDS = [
        'receive_email_notification',
        'receive_other_emails',
        'receive_sms',
    ];

    /**
     * @param User $user
     * @param array $data
     */
    public function execute(User $user, array $data): void
    {
        $user->notificationSettings->update(Arr::only($data, $this::FIELDS));
    }
}
