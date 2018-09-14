<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reel()
    {
        return $this->hasOne(CrewReel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resume()
    {
        return $this->hasOne(CrewResume::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gears()
    {
        return $this->hasMany(CrewGear::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socials()
    {
        return $this->hasMany(CrewSocial::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function endorsementRequests()
    {
        return $this->hasManyThrough(EndorsementRequest::class, CrewPosition::class, 'crew_id', 'crew_position_id', 'id', 'id');
    }

    /**
     * @param Position $position
     * @param $attributes
     */
    public function applyFor(Position $position, $attributes)
    {
        $this->positions()->attach($position, [
            'details' => $attributes['details'],
            'union_description' => $attributes['union_description']
        ]);
    }

    /**
     * @param EndorsementRequest $endorsementRequest
     * @param array $attributes
     * @return Model
     */
    public function approve(EndorsementRequest $endorsementRequest, $attributes = [])
    {
        return Endorsement::firstOrCreate(
            [
                'endorsement_request_id' => $endorsementRequest->id,
                'endorser_id' => $this->id,
            ],
            [
                'approved_at' => Carbon::now(),
                'comment' => $attributes['comment'] ?? null,
            ]
        );
    }

    /**
     * @param $position
     * @return bool
     */
    public function hasPosition($position)
    {
        return $this->positions()->where('position_id', $position->id)->get()->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function endorsements()
    {
        return $this->hasMany(Endorsement::class, 'endorser_id');
    }
}
