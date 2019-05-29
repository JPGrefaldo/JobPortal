<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDeniedReason extends Model
{
    /**
     * Table name reference
     *
     * @var string
     */
    protected $table = 'project_denied_reasons';

    /**
     * Unwritable table field
     *
     * @var array
     */
    protected $guarded = ['id'];
}
