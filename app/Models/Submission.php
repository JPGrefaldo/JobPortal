<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Submission extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(ProjectJob::class);
    }

    /**
     * @return BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    /**
     * @return HasOne
     */
    public function note()
    {
        return $this->hasOne(SubmissionNote::class);
    }
}
