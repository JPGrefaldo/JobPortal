<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
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
        'name'             => 'string',
        'department_id'    => 'integer',
        'position_type_id' => 'integer',
        'has_gear'         => 'boolean',
        'has_union'        => 'boolean',
        'has_many'         => 'boolean',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function crews()
    {
        return $this->belongsToMany(Crew::class);
    }

    public function crewPosition()
    {
        return $this->belongsTo(CrewPosition::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(PositionTypes::class);
    }
}
