<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PositionType extends Model
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
        'id'    => 'integer',
        'name'  => 'string',
        'order' => 'integer',
    ];

    /**
     * @return HasMany
     */
    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}
