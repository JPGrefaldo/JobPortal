<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
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
        'name'        => 'string',
        'description' => 'string',
    ];

    /**
     * @return HasMany
     */
    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    /**
     * @param string $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return str_replace('_', ' ', $value);
    }
}
