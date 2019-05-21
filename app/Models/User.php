<?php

namespace App\Models;

use App\Models\Traits\LogsActivityOnlyDirty;
use App\Utils\StrUtils;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Vinkla\Hashids\Facades\Hashids;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,
        LogsActivityOnlyDirty,
        Messagable,
        HasRoles,
        Billable;

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
        'id'         => 'integer',
        'hash_id'    => 'string',
        'first_name' => 'string',
        'last_name'  => 'string',
        'email'      => 'string',
        'nickname'   => 'string',
        'phone'      => 'string',
        'status'     => 'integer',
        'confirmed'  => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->hash_id = Hashids::encode($user->id);
            $user->save();
        });
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function crew()
    {
        return $this->hasOne(Crew::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messageTemplates()
    {
        return $this->hasMany(MessageTemplate::class);
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

    /**
     *
     */
    public function confirm()
    {
        $this->update([
            'confirmed' => 1,
        ]);
    }

    /**
     *
     */
    public function deactivate()
    {
        $this->update([
            'status' => 0,
        ]);
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
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return string
     */
    public function getNicknameAttribute($nickname)
    {
        return $nickname;
    }

    /**
     * @return string
     */
    public function getNicknameOrFullNameAttribute()
    {
        return (isset($this->nickname) && $this->nickname) ?
                $this->nickname :
                $this->full_name;
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->nickname_or_full_name;
    }

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        if ($this->hasRole(\App\Models\Role::CREW)) {
            if (isset($this->crew->photo_path) && ! empty($this->crew->photo_path)) {
                return $this->crew->photo_url;
            }
        }

        return \Avatar::create($this->full_name)->toBase64();
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'hash_id';
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
