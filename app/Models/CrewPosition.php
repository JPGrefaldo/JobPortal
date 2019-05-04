<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CrewReel;
use App\Models\CrewResume;
use App\Models\CrewGear;

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
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $casts = [
        'id'                => 'integer',
        'crew_id'           => 'integer',
        'position_id'       => 'integer',
        'details'           => 'string',
        'union_description' => 'string',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function endorsements()
    {
        return $this->hasMany(Endorsement::class, 'crew_position_id');
    }

    /**
     * @return integer
     */
    public function getScoreAttribute()
    {
        $ret = $this->hasOne(CrewPositionEndorsementScore::class, 'crew_position_id')->first();

        if (! $ret) {
            return 1;
        }

        return $ret->score;
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

    /**
     * @param $value
     */
    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = (is_null($value) ? '' : $value);
    }

    /**
     * @param $value
     */
    public function setUnionDescriptionAttribute($value)
    {
        $this->attributes['union_description'] = (is_null($value) ? '' : $value);
    }

    public function reel()
    {
        return $this->hasOne(CrewReel::class,'crew_position_id');
    }

    public function gear()
    {
        return $this->belongsTo(CrewGear::class);
    }

    public function resume()
    {
        return $this->belongsTo(CrewResume::class);
    }
}
