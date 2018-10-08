<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EndorsementRequest extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'crew_position_id' => 'integer',
        'token' => 'string',
    ];

    /**
     * @return string
     */
    public static function generateToken()
    {
        do {
            $token = str_random();
        } while (static::where('token', $token)->first());
        return $token;
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crewPosition()
    {
        return $this->belongsTo(CrewPosition::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function endorsements()
    {
        return $this->hasMany(Endorsement::class);
    }

    /**
     * @param Crew $crew
     * @return mixed
     */
    public function endorsementBy(Crew $crew)
    {
        return $this->endorsements->where('endorser_id', $crew->id)->first();
    }

    /**
     * @param Crew $crew
     * @return bool
     */
    public function isApprovedBy(Crew $crew)
    {
        return !! $this->endorsementBy($crew);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function endorsee()
    {
        return $this->crewPosition->crew();
    }

    /**
     * @param Crew $crew
     * @return bool
     */
    public function isRequestedBy(Crew $crew)
    {
        return $this->endorsee->id === $crew->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->crewPosition->position();
    }

    public function isAskedToEndorse(string $email)
    {
        return $this->endorsements->where('endorser_email', $email)->count() > 0;
    }
}
