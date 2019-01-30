<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionTypes extends Model
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
        'id' => 'integer',
        'name' => 'string',
        'name' => 'description',
        'order' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}
