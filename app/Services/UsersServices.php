<?php


namespace App\Services;


use App\Models\User;
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
        $data         = $this->prepareData($data);
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
        $data['first_name'] = $this->formatName($data['first_name']);
        $data['last_name']  = $this->formatName($data['last_name']);
        $data['email']      = $this->formatEmail($data['email']);
        $data['password']   = $this->hashPassword($data['password']);
        $data['phone']      = $this->formatPhone($data['phone']);

        return $data;
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
    public function formatName(string $value)
    {
        return StrUtils::formatName($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function formatEmail(string $value)
    {
        return strtolower($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function hashPassword(string $value)
    {
        return Hash::make($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function formatPhone(string $value)
    {
        return StrUtils::formatPhone($value);
    }
}
