<?php


namespace App\Services;


use App\Models\User;
use App\Utils\StrUtils;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersServices
{
    /**
     * @param array $userData
     * @param array $notificationSettingsData
     *
     * @return \App\Models\User
     */
    public function create(array $userData, array $notificationSettingsData)
    {
        $user = User::create([
            'uuid'       => Str::uuid(),
            'first_name' => $userData['first_name'],
            'last_name'  => $userData['last_name'],
            'email'      => $userData['email'],
            'password'   => Hash::make($userData['password']),
            'phone'      => $userData['phone'],
        ]);

        $notificationSettingsData['receive_sms'] = $notificationSettingsData['receive_sms'] ?? 0;

        $user->notificationSettings()->create($notificationSettingsData);

        return $user;
    }

    /**
     * @param string           $firstName
     * @param string           $lastName
     * @param \App\Models\User $user
     *
     * @return \App\Models\User
     */
    public function updateName(string $firstName, string $lastName, User $user)
    {
        $user->update([
            'first_name' => $this->formatName($firstName),
            'last_name'  => $this->formatName($lastName),
        ]);

        return $user;
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function formatName($value)
    {
        return StrUtils::formatName($value);
    }
}
