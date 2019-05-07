<?php

namespace App\Models;

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
     * The fillable attributes
     *
     * @var array
     */
    protected $fillable = ['crew_id', 'crew_position_id', 'path', 'general'];

    /**
     * @var array
     */
    protected $casts = [
        'id'               => 'integer',
        'crew_id'          => 'integer',
        'url'              => 'string',
        'general'          => 'boolean',
        'crew_position_id' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }
}
