<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrewGear extends Model
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
        'crew_id'          => 'integer',
        'description'      => 'string',
        'crew_position_id' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    /**
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = (is_null($value) ? '' : $value);
    }
}
