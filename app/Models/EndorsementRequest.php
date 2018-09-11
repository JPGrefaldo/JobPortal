<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EndorsementRequest extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'integer',
        'crew_position_id' => 'integer',
        'token' => 'string',
    ];

    public static function generateToken()
    {
        do {
            $token = str_random();
        } while (static::where('token', $token)->first());
        return $token;
    }

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function crewPosition()
    {
        return $this->belongsTo(CrewPosition::class);
    }

    public function endorsements()
    {
        return $this->hasMany(Endorsement::class);
    }

    public function endorsementBy(Crew $crew)
    {
        return $this->endorsements->where('endorser_id', $crew->id)->first();
    }

    public function isApprovedBy(Crew $crew)
    {
        return !! $this->endorsementBy($crew);
    }

    public function endorsee()
    {
        return $this->crewPosition->crew();
    }

    public function isRequestedBy($user = null)
    {
        if (! $user) {
            $user = auth()->user();
        }
        return $this->endorsee->user->id === $user->id;
    }

    public function position()
    {
        return $this->crewPosition->position();
    }
}
