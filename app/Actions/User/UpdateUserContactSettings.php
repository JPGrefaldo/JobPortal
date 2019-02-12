<?php
namespace App\Actions\User;


use App\Models\User;
use App\Utils\StrUtils;

class UpdateUserContactSettings
{
    const FIELDS = [
        'phone',
        'email',
    ];

    /**
     * @param User $user
     * @param array $data
     */
    public function execute(User $user, array $data)
    {
        $user->update($this->cleanData($data));
    }

    /**
     * @param $data
     * @return array
     */
    public function cleanData(array $data)
    {
        $data = array_only($data, $this::FIELDS);

        if (isset($data['phone'])) {
            $data['phone'] = StrUtils::stripNonNumeric($data['phone']);
        }

        return $data;
    }
}