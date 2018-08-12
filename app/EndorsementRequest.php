<?php

namespace App;

use App\Models\CrewPosition;
use App\Models\Endorsement;
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

    public function endorsementBy($user)
    {
        return $this->endorsements->where('endorser_email', $user->email);
    }

    public function isApprovedBy($user)
    {
        return $this->endorsementBy($user)->count() > 0;
    }

    public function isRequestedBy($user)
    {
        return $this->endorsee->user->id === $user->id;
    }

    public function endorsee()
    {
        return $this->crewPosition->crew();
    }

    public function endorsers()
    {
        return $this->endorsements->endorser();
    }

    public function position()
    {
        return $this->crewPosition->position();
    }
}
