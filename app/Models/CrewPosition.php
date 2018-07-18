<?php

namespace App\Models;

use App\Models\Position;
use Illuminate\Database\Eloquent\Model;

class CrewPosition extends Model
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
        'id'          => 'integer',
        'crew_id'     => 'integer',
        'position_id' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
