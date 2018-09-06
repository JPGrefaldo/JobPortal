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

    // public function endorsers()
    // {
    //     // return $this->hasMany(Crew::class, 'id', 'endorser_id');
    //     return $this->belongsToMany(Crew::class, )
    // }

    // public function endorsementBy(Crew $crew)
    // {
    // this should be crew's
    //     return $this->endorsements->where('endorser_id', $user->email)->first();
    // }

    public function isApprovedBy($user)
    {
        return !! $this->endorsementBy($user);
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

    // public function endorsers()
    // {
    //     // return $this->endorsements()->endorser;
    //     // return $this->endorsements()->endorser();
    //     // return $this->endorsements->endorser;
    //     return $this->endorsements->endorser();
    // }

    public function position()
    {
        return $this->crewPosition->position();
    }
}
