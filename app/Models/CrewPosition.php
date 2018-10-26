<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrewPosition extends Pivot
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
        'id'          => 'integer',
        'crew_id'     => 'integer',
        'position_id' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Crew $crew
     * @param Position $position
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCrewAndPosition($query, $crew, $position)
    {
        return $query->where('crew_id', $crew->id)
                     ->where('position_id', $position->id);
    }
}
