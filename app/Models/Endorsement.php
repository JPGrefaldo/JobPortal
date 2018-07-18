<?php

namespace App\Models;

use App\Models\CrewPosition;
use Illuminate\Database\Eloquent\Model;

class Endorsement extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id'               => 'integer',
        'crew_position_id' => 'integer',
        'endorser_name'    => 'string',
        'endorser_email'   => 'string',
        'token'            => 'string',
        'approved_at'      => 'datetime',
        'comment'          => 'string',
        'deleted'          => 'boolean',
    ];

    public static function generateToken()
    {
        do {
            $token = str_random();
        } while (static::where('token', $token)->first());
        return $token;
    }

    public function crewPosition()
    {
        return $this->belongsTo(CrewPosition::class);
    }

    public function position()
    {
        return $this->crewPosition->position();
    }
}
