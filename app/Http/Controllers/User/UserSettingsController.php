<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rules\UserRules;
use App\Services\User\UserSettingsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class UserSettingsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function updateName(Request $request)
    {
        $data = $this->validate($request, [
            'first_name' => UserRules::FIRST_NAME,
            'last_name'  => UserRules::LAST_NAME,
        ]);

        Auth::user()->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function updateNotifications(Request $request)
    {
        $data = $this->validate($request, [
            'receive_email_notification' => 'bool',
            'receive_other_emails'       => 'bool',
            'receive_sms'                => 'bool',
        ]);

        app(UserSettingsServices::class)->updateNotifications(
            $data,
            Auth::user()->notificationSettings
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $data = $this->validate($request, [
            'current_password' => [
                'required',
                'string',
                'min:6',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail('The current password is invalid.');
                    }

                    return true;
                },
            ],
            'password'         => 'required|string|min:6|confirmed',
        ]);

        $user->update(['password' => Hash::make($data['password'])]);
    }
}
