<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
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

    // TODO: create test
    public function contributors()
    {
    }
}
