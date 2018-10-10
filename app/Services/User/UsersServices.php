<?php


namespace App\Services\User;

use App\Models\User;
use App\Utils\FormatUtils;
use App\Utils\StrUtils;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersServices
{
    /**
     * @param array $data
     *
     * @return \App\Models\User
     */
    public function create(array $data)
    {
        $data = $this->prepareData($data);
        $data['uuid'] = Str::uuid();

        return User::create($data);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function prepareData(array $data)
    {
        $data['first_name'] = FormatUtils::name($data['first_name']);
        $data['last_name'] = FormatUtils::name($data['last_name']);
        $data['email'] = FormatUtils::email($data['email']);
        $data['password'] = Hash::make($data['password']);
        $data['phone'] = StrUtils::stripNonNumeric($data['phone']);

        return $data;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param \App\Models\User $user
     *
     * @return \App\Models\User
     */
    public function updateName(string $firstName, string $lastName, User $user)
    {
        $user->update([
            'first_name' => FormatUtils::name($firstName),
            'last_name'  => FormatUtils::name($lastName),
        ]);

        return $user;
    }

    /**
     * @param string $email
     * @param string $phone
     *
     * @param \App\Models\User $user
     *
     * @return \App\Models\User
     */
    public function updateContact(string $email, string $phone, User $user)
    {
        $user->update([
            'email' => FormatUtils::email($email),
            'phone' => StrUtils::stripNonNumeric($phone),
        ]);

        return $user;
    }

    /**
     * @param string $password
     * @param \App\Models\User $user
     *
     * @return \App\Models\User
     */
    public function updatePassword(string $password, User $user)
    {
        $user->update(['password' => Hash::make($password)]);

        return $user;
    }
}
