<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    /**
     * @return BelongsTo
     */
    public function pay_type()
    {
        return $this->belongsTo(PayType::class);
    }

    /**
     * @return HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'project_job_id');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function crewIgnoredJobs()
    {
        return $this->hasMany(CrewIgnoredJobs::class, 'project_job_id');
    }
}
