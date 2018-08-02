<?php

namespace App\Models;

use App\Exceptions\ElectoralFraud;
use App\Models\Crew;
use App\Models\Traits\LogsActivityOnlyDirty;
use App\Utils\StrUtils;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, LogsActivityOnlyDirty;

    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id'        => 'integer',
        'status'    => 'integer',
        'confirmed' => 'boolean',
    ];

    /**
     * roles many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * sites many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sites()
    {
        return $this->belongsToMany(Site::class, 'user_sites');
    }

    /**
     * user_notification_settings relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function notificationSettings()
    {
        return $this->hasOne(UserNotificationSetting::class);
    }

    /**
     * email_verification_tokens relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emailVerificationCode()
    {
        return $this->hasOne(EmailVerificationCode::class);
    }

    /**
     * user_banned relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function banned()
    {
        return $this->hasOne(UserBanned::class);
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return ($this->confirmed == 1);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return ($this->status === 1);
    }

    public function confirm()
    {
        $this->update([
            'confirmed' => 1,
        ]);
    }

    public function deactivate()
    {
        $this->update([
            'status' => 0,
        ]);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasRole($name)
    {
        return $this->roles()->get()
                    ->contains('name', $name);
    }

    /**
     * @param string $hostname
     *
     * @return bool
     */
    public function hasSite($hostname)
    {
        return $this->sites()->get()
                    ->contains('hostname', $hostname);
    }

    /**
     * @return string
     */
    public function getFormattedPhoneNumberAttribute()
    {
        return StrUtils::formatPhone($this->phone);
    }

    /**
     * endorse a User to a ProjectJob
     * @param  \App\Models\User $endorsee
     * @param  \App\Models\ProjectJob $projectJob
     * @return \App\Models\Endorsement
     */
    public function endorse($endorsee, $projectJob)
    {
        if ($this->id === $endorsee->id) {
            throw new ElectoralFraud('You can\'t endorse yourself.');
        }

        return Endorsement::create([
            'project_job_id' => $projectJob->id,
            'endorser_id'    => $this->id,
            'endorsee_id'    => $endorsee->id,
        ]);
    }

    public function crew()
    {
        return $this->hasOne(Crew::class);
    }

    public function hasPosition($position)
    {
        return $this->crew->positions()->where('position_id', $position->id)->get()->count() > 0;
    }
}
