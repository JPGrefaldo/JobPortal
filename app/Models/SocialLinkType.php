<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLinkType extends Model
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
        'id'         => 'integer',
        'name'       => 'string',
        'image'      => 'string',
        'sort_order' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function crew()
    {
        return $this->hasMany(CrewSocial::class);
    }

    /**
     * @return string
     */
    public function getSlugAttribute()
    {
        return snake_case(strtolower($this->name));
    }
}
