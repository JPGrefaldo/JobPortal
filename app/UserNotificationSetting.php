<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'receive_sms'
    ];
}
