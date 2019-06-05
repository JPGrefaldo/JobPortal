<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrewPosition extends Pivot
{
    use SoftDeletes;

    /**
     * @var bool
     */
    public $incrementing = true;
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
        'id'                => 'integer',
        'crew_id'           => 'integer',
        'position_id'       => 'integer',
        'details'           => 'string',
        'union_description' => 'string',
    ];

    /**
     * @return BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    /**
     * @return BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * @return HasMany
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
     * @param Builder $query
     * @param Crew $crew
     * @param Position $position
     * @return Builder
     */
    public function scopeByCrewAndPosition($query, $crew, $position)
    {
        return $query->withTrashed()->where('crew_id', $crew->id)
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

    /**
     * @return HasOne
     */
    public function reel()
    {
        return $this->hasOne(CrewReel::class, 'crew_position_id');
    }

    /**
     * @return HasOne
     */
    public function gear()
    {
        return $this->hasOne(CrewGear::class, 'crew_position_id');
    }

    /**
     * @return HasOne
     */
    public function resume()
    {
        return $this->hasOne(CrewResume::class, 'crew_position_id');
    }
}
