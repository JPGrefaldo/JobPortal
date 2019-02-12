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
    public function execute(User $user, array $data)
    {
        $user->refresh();
        if ($user->hasRole(Role::PRODUCER)) {
            $data['receive_sms'] = true;
        }

        return UserNotificationSetting::create([
            'user_id'     => $user->id,
            'receive_sms' => array_get($data, 'receive_sms', 0),
        ]);
    }
}