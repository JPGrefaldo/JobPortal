<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EndorsementEndorser extends Model
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
        'email'   => 'string',
    ];

    /**
     * Users many to many relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEmailAttribute($value)
    {
        if (! is_null($value)) {
            return $value;
        }

        return $this->user->email;
    }
}
