<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
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
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function threads()
    {
        return $this->belongsToMany(Thread::class);
    }

    public static function getSitesByIds(array $siteIds)
    {
        if (count($siteIds) === 1 && $siteIds[0] === 'all') {
            $siteIds = Site::all()->pluck('id');
        }

        return $siteIds;
    }
}
