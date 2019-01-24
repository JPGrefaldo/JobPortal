<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerificationCode extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id'      => 'integer',
        'user_id' => 'integer',
        'code'    => 'string',
    ];

    /**
     * users relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
