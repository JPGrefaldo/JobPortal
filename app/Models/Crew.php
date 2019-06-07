<?php

namespace App\Models;

use App\Utils\UrlUtils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
        'id'               => 'integer',
        'user_id'          => 'integer',
        'bio'              => 'string',
        'photo'            => 'string',
        'submission_count' => 'integer',
    ];

    /**
     * Users many to many relationship
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
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

        return UrlUtils::getS3Url() . $this->photo_path;
    }

    /**
     * @return bool
     */
    public function hasGeneralReel(): bool
    {
        return $this->reels()->where('general', true)->count() > 0;
    }

    /**
     * @return HasMany
     */
    public function reels()
    {
        return $this->hasMany(CrewReel::class);
    }

    /**
     * @return bool
     */
    public function hasGeneralResume(): bool
    {
        return $this->resumes()->whereGeneral(true)->count() > 0;
    }

    /**
     * @return HasMany
     */
    public function resumes()
    {
        return $this->hasMany(CrewResume::class);
    }

    /**
     * @param $job
     * @return bool
     */
    public function hasAppliedTo($job): bool
    {
        return $this->submissions()->where('project_job_id', $job->id)->count() > 0;
    }

    /**
     * @return HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * @return string
     */
    public function getGeneralReelLink()
    {
        $reelPath = optional($this->reels()->whereGeneral(true)->first())->link;

        return ($reelPath) ?? '';
    }

    /**
     * @return string
     */
    public function getGeneralResumeLink()
    {
        $resumePath = optional($this->resumes()->whereGeneral(true)->first())->link;

        return ($resumePath) ?? '';
    }

    /**
     * @return HasMany
     */
    public function gears()
    {
        return $this->hasMany(CrewGear::class);
    }

    /**
     * @return HasMany
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
     * @return BelongsToMany
     */
    public function positions()
    {
        return $this->belongsToMany(Position::class)->withTimestamps()->withPivot('details');
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
     * @return HasManyThrough
     */
    public function endorsements()
    {
        return $this->hasManyThrough(Endorsement::class, CrewPosition::class, 'crew_id', 'crew_position_id', 'id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Set the crew submissions count
     *
     * @param integer $value
     * @return void
     */
    public function setSubmissionCountAttribute($value)
    {
        $this->attributes['submission_count'] = $value;
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function ignoredJobs()
    {
        return $this->hasMany(CrewIgnoredJob::class);
    }

    public function unignoreJob($job)
    {
        return $this->ignoredJobs()->where('project_job_id',$job->id)->delete();
    }
}
