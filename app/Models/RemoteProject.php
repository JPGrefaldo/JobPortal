<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemoteProject extends Model
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
        'id'         => 'integer',
        'project_id' => 'integer',
        'site_id'    => 'integer',
    ];
}
