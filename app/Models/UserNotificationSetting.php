<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id'                         => 'integer',
        'user_id'                    => 'integer',
        'receive_email_notification' => 'boolean',
        'receive_other_emails'       => 'boolean',
        'receive_sms'                => 'boolean',
    ];
}
