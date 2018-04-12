<?php


namespace App\Services;


use App\User;
use App\Utils\StrUtils;
use Illuminate\Support\Facades\Hash;

class UsersServices
{
    /**
     * @param array $userData
     * @param array $notificationSettingsData
     *
     * @return \App\User
     */
    public function create(array $userData, array $notificationSettingsData)
    {
        $user = User::create([
            'first_name' => $userData['first_name'],
            'last_name'  => $userData['last_name'],
            'email'      => $userData['email'],
            'password'   => Hash::make($userData['password']),
            'phone'      => $this->formatPhone($userData['phone']),
        ]);

        $notificationSettingsData['receive_sms'] = $notificationSettingsData['receive_sms'] ?? 0;

        $user->notificationSettings()->create($notificationSettingsData);

        return $user;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public static function formatPhone($value)
    {
        return preg_replace(
            "/([0-9]{3})([0-9]{3})([0-9]{4})/",
            "($1) $2-$3",
            StrUtils::stripNonNumeric($value)
        );
    }
}