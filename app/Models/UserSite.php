<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserSite extends Pivot
{
    /**
     * @var bool
     */
    public $incrementing = true;
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];
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
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_sites');
    }
}
