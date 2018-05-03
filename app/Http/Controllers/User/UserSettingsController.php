<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserSettingsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class UserSettingsController extends Controller
{
    public function updateName(Request $request)
    {
        $data = $this->validate($request, [
            'first_name' => ['required', 'max:255', "regex:/^[a-z'\- ]*$/i"],
            'last_name'  => ['required', 'max:255', "regex:/^[a-z'\- ]*$/i"],
        ]);

        Auth::user()->update([
            'first_name' => ucwords(strtolower($data['first_name'])),
            'last_name'  => ucwords(strtolower($data['last_name']))
        ]);

        /** @temp  log updates */
        $activityLog = Activity::orderBy('id', 'desc')->first();
        $changes = $activityLog->changes();

        foreach ($changes['attributes'] as $key => $value) {
            \Log::info('User ' . $activityLog->subject->id . ' changed ' . $key . ' from ' . $changes['old'][$key] . ' to ' . $value);
        }
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
