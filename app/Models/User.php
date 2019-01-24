<?php

namespace App\Models;

use App\Models\Traits\LogsActivityOnlyDirty;
use App\Utils\StrUtils;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Vinkla\Hashids\Facades\Hashids;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,
        LogsActivityOnlyDirty,
        Messagable;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->hash_id = Hashids::encode($user->id);
            $user->save();
        });
    }
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
        'phone'      => 'string',
        'status'     => 'integer',
        'confirmed'  => 'boolean',
    ];

    /**
     * roles many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id', 'id');
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

    public function projects()
    {
        return $this->hasMany(Project::class);
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
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /***
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAreCrew($query)
    {
        return $query->select(['users.*', 'user_roles.role_id'])
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('role_id', '=', Role::getRoleIdByName(Role::CREW));
    }

    /***
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAreProducer($query)
    {
        return $query->select(['users.*', 'user_roles.role_id'])
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('role_id', '=', Role::getRoleIdByName(Role::PRODUCER));
    }

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
