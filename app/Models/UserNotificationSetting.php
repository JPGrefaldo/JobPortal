<?php

namespace App\Models;

use App\Models\Traits\LogsActivityOnlyDirty;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    use LogsActivityOnlyDirty;

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

    /**
     * Users many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_notification_settings');
    }
}
