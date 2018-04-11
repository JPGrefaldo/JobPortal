<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrewResume extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }
}
