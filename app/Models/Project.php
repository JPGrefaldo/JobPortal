<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    const PENDING    = 0;
    const APPROVED   = 1;
    const UNAPPROVED = 2;

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
        'id'                     => 'integer',
        'user_id'                => 'integer',
        'site_id'                => 'integer',
        'title'                  => 'string',
        'production_name'        => 'string',
        'production_name_public' => 'boolean',
        'project_type_id'        => 'integer',
        'description'            => 'string',
        'location'               => 'string',
        'status'                 => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'project_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function remotes()
    {
        return $this->hasMany(RemoteProject::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany(ProjectJob::class, 'project_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contributors()
    {
        return $this->belongsToMany(Crew::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function threads()
    {
        return $this->belongsToMany(Thread::class);
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function deniedReason()
    {
        return $this->hasOne(ProjectDeniedReason::class);
    }

    /**
     * @return bool
     */
    public function approve()
    {
        return $this->update(
            [
                'approved_at' => Carbon::now(),
                'status'      => static::APPROVED,
            ]
        );
    }

    /**
     * @return bool
     */
    public function unapprove()
    {
        return $this->update(
            [
                'approved_at'   => null,
                'unapproved_at' => Carbon::now(),
                'status'        => static::UNAPPROVED,
            ]
        );
    }

    /**
     * @param array $siteIds
     * @return array|\Illuminate\Support\Collection
     */
    public function getSitesByIds(array $siteIds)
    {
        if (count($siteIds) === 1 && $siteIds[0] === 'all') {
            $siteIds = Site::all()->pluck('id');
        }

        return $siteIds;
    }

    public function scopeGetPending()
    {
        return $this->where('status', 0)->get();
    }

    public function scopeGetApproved()
    {
        return $this->where('status', 1)->get();
    }
}
