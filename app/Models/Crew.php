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
        return $this->hasOne(User::class, 'id', 'user_id');
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
    public function gears()
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

    public function endorsementRequests()
    {
        return $this->hasManyThrough(EndorsementRequest::class, CrewPosition::class, 'crew_id', 'crew_position_id', 'id', 'id');
    }

    public function applyFor(Position $position, $attributes)
    {
        $this->positions()->attach($position, [
            'details' => $attributes['details'],
            'union_description' => $attributes['union_description']
        ]);
    }

    public function approve(EndorsementRequest $endorsementRequest, $attributes = [])
    {
        return Endorsement::create([
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_id' => $this->user->id,
            'endorser_email' => $this->user->email,
            'approved_at' => Carbon::now(),
            'comment' => $attributes['comment'] ?? null,
        ]);
    }

    /**
     * endorse a User to a ProjectJob
     * @param  \App\Models\User $endorsee
     * @param  \App\Models\ProjectJob $projectJob
     * @return \App\Models\Endorsement
     */
    public function endorse($endorsee, $projectJob)
    {
        if ($this->id === $endorsee->id) {
            return false;
        }

        return Endorsement::create([
            'project_job_id' => $projectJob->id,
            'endorser_id' => $this->id,
            'endorsee_id' => $endorsee->id,
        ]);
    }

    public function hasPosition($position)
    {
        return $this->positions()->where('position_id', $position->id)->get()->count() > 0;
    }
}
