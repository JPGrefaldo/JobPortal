<?php

namespace App\Actions\User;

use App\Models\User;

class UpdateUserNotificationSettings
{
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
        $user->notificationSettings->update(array_only($data, $this::FIELDS));
    }
}