<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * @return BelongsToMany
     */
    public function crews()
    {
        return $this->belongsToMany(Crew::class)->withPivot('details');
    }

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(PositionType::class);
    }

    /**
     * @param string $value
     * @return string mixed
     */
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
