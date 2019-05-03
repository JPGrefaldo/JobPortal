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
        'bio'     => 'string',
        'photo'   => 'string',
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
    public function crewPositions()
    {
        return $this->hasMany(CrewPosition::class);
    }

    /**
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        if (empty($this->photo_path)) {
            return '';
        }

        return config('filesystems.disks.s3.url') . '/' . config('filesystems.disks.s3.bucket') . '/' . $this->photo_path;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function positions()
    {
        return $this->belongsToMany(Position::class)->withTimestamps()->withPivot('details');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reels()
    {
        return $this->hasMany(CrewReel::class);
    }

    public function hasGeneralReel(): bool
    {
        return $this->reels()->where('general', true)->count() > 0;
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
    public function socials()
    {
        return $this->hasMany(CrewSocial::class);
    }

    /**
     * @param Position $position
     * @param $attributes
     */
    public function applyFor(Position $position, $attributes)
    {
        $this->positions()->attach($position, [
            'details'           => $attributes['details'],
            'union_description' => $attributes['union_description'],
        ]);
    }

    /**
     * @param EndorsementRequest $endorsementRequest
     * @param array $attributes
     * @return Model
     */
    public function approve(EndorsementRequest $endorsementRequest, $attributes = [])
    {
        return Endorsement::updateOrCreate(
            [
                'endorsement_request_id' => $endorsementRequest->id,
                'endorser_email'         => $this->user->email,
            ],
            [
                'endorser_id' => $this->id,
                'comment'     => $attributes['comment'] ?? null,
                'approved_at' => Carbon::now(),
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
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function endorsements()
    {
        return $this->hasManyThrough(Endorsement::class, CrewPosition::class, 'crew_id', 'crew_position_id', 'id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}