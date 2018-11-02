<?php

namespace App\Actions\User;

use App\Models\User;
use App\Utils\FormatUtils;
use App\Utils\StrUtils;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function execute($data)
    {
        $data = $this->prepareData($data);

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
}
