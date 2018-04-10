<?php


namespace App\Services;


use App\User;
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
            'phone'      => $userData['phone'],
        ]);

        $user->notificationSettings()->create($notificationSettingsData);

        return $user;
    }
}