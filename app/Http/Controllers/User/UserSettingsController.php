<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rules\UserRules;
use App\Services\UsersServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSettingsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function updateName(Request $request)
    {
        $data = $this->validate($request, [
            'first_name' => UserRules::firstName(),
            'last_name'  => UserRules::lastName(),
        ]);

        app(UsersServices::class)->updateName(
            $data['first_name'],
            $data['last_name'],
            Auth::user()
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        $data = $this->validate($request, [
            'email'                      => UserRules::email($user->id),
            'phone'                      => UserRules::phone(),
            'receive_email_notification' => 'bool',
            'receive_other_emails'       => 'bool',
            'receive_sms'                => 'bool',
        ]);

        app(UsersServices::class)->updateContact($data['email'], $data['phone'], $user);
        $user->notificationSettings->update([
            'receive_email_notification' => array_get($data, 'receive_email_notification', 0),
            'receive_other_emails'       => array_get($data, 'receive_other_emails', 0),
            'receive_sms'                => array_get($data, 'receive_sms', 0),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $data = $this->validate($request, [
            'current_password' => array_merge(
                UserRules::password(),
                [
                    function ($attribute, $value, $fail) use ($user) {
                        return Hash::check($value, $user->password)
                            ? true
                            : $fail('The current password is invalid.');
                    },
                ]
            ),
            'password'         => array_merge(UserRules::password(), ['confirmed']),
        ]);

        app(UsersServices::class)->updatePassword($data['password'], $user);
    }
}
