<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectJob extends Model
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
        'id'                   => 'integer',
        'persons_needed'       => 'integer',
        'pay_rate'             => 'float',
        'rush_call'            => 'boolean',
        'travel_expenses_paid' => 'boolean',
        'remote'               => 'boolean',
        'status'               => 'integer',
        'project_id'           => 'integer',
        'position_id'          => 'integer',
        'pay_type_id'          => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
