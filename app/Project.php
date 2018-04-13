<?php

namespace App;

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
        'status'                 => 'integer',
        'production_name_public' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(ProjectType::class, 'id', 'project_type_id');
    }
}