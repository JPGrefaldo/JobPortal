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
        'project_type_id'        => 'integer',
        'user_id'                => 'integer',
        'status'                 => 'integer',
        'production_name_public' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
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
        return $this->hasMany(ProjectJob::class);
    }

    public function contributors()
    {
        return $this->belongsToMany(Crew::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function threads()
    {
        return $this->belongsToMany(Thread::class);
    }

    public function getAcronymAttribute()
    {
        $words = explode(' ', $this->title);

        $acronym = '';

        for ($i = 0; $i < 2; $i++) {
            $acronym .= $words[$i][0];
        }
        return strtoupper($acronym);
    }
}
