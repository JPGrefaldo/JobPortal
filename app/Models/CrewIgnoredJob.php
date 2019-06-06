<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrewIgnoredJob extends Model
{
    /**
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
