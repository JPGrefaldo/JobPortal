<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserSites extends Pivot
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var string
     */
    protected $table = 'user_sites';

    /**
     * @var array
     */
    protected $casts = [
        'id'      => 'integer',
        'site_id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Users many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_sites');
    }
}
