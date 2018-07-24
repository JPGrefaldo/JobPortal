<?php

namespace App;

use App\Models\CrewPosition;
use Illuminate\Database\Eloquent\Model;

class EndorsementRequest extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id'               => 'integer',
        'crew_position_id' => 'integer',
        'token'            => 'string',
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
}
