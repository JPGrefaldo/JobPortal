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
        'project_id'           => 'integer',
        'position_id'          => 'integer',
        'pay_type_id'          => 'integer',
        'persons_needed'       => 'integer',
        'dates_needed'         => 'array',
        'pay_rate'             => 'float',
        'notes'                => 'string',
        'rush_call'            => 'boolean',
        'travel_expenses_paid' => 'boolean',
        'gear_provided'        => 'string',
        'gear_needed'          => 'string',
        'status'               => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
