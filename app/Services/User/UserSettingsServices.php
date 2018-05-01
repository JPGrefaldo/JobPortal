<?php


namespace App\Services\User;


use App\Models\UserNotificationSetting;

class UserSettingsServices
{
    /**
     * @param array                               $data
     * @param \App\Models\UserNotificationSetting $notifications
     *
     * @return \App\Models\UserNotificationSetting
     */
    public function updateNotifications(array $data, UserNotificationSetting $notifications)
    {
        $notifications->update([
            'receive_email_notification' => array_get($data, 'receive_email_notification', 0),
            'receive_other_emails'       => array_get($data, 'receive_other_emails', 0),
            'receive_sms'                => array_get($data, 'receive_sms', 0),
        ]);

        return $notifications;
    }
}