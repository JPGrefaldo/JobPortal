<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserSettingsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
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
}
