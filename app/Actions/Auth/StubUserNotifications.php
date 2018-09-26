<?php

namespace App\Actions\Auth;


use App\Models\Role;
use App\Models\User;
use App\Models\UserNotificationSetting;

class StubUserNotifications
{
    /**
     * @param User $user
     * @param array $data
     * @return UserNotificationSetting|\Illuminate\Database\Eloquent\Model
     */
    public function execute($user, $data)
    {
        return UserNotificationSetting::create([
            'user_id'     => $user->id,
            'receive_sms' => (! in_array('receive_sms', $data))
                ? 1
                : array_get($data, 'receive_sms', 0),
        ]);
    }
}