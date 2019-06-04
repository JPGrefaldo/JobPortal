<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBanned extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'user_banned';

    /**
     * @var array
     */
    protected $casts = [
        'id'      => 'integer',
        'user_id' => 'integer',
        'reason'  => 'string',
    ];

    /**
     * Users many to many relationship
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
