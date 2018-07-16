<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
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
        'id'      => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Users many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions()
    {
        return $this->hasMany(CrewPosition::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reels()
    {
        return $this->hasMany(CrewReel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resumes()
    {
        return $this->hasMany(CrewResume::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gear()
    {
        return $this->hasMany(CrewGear::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function social()
    {
        return $this->hasMany(CrewSocial::class);
    }

    public function appliesFor(Position $position, $attributes)
    {
        return CrewPosition::create([
            'crew_id' => $this->id,
            'position_id' => $position->id,
            'details' => $attributes['details'],
            'union_description' => $attributes['union_description'],
        ]);
    }

    public function askEndorsementFrom($endorserEmail, Position $position)
    {
        return Endorsement::create([
            'position_id' => $position->id,
            'endorser_email' => $endorserEmail,
        ]);
    }

    public function acceptEndorsement(Endorsement $endorsement)
    {
        $endorsement->accepted_at = Carbon::now();
        $endorsement->save();
        return $endorsement
    }
}
