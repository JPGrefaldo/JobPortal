<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'id'               => 'integer',
        'user_id'          => 'integer',
        'email'            => 'string',
        'request_owner_id' => 'integer',
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

    /**
     * @param $value
     * @return null|string
     */
    public function getEmailAttribute($value)
    {
        if (! is_null($value)) {
            return $value;
        }

        return $this->user->email;
    }

    public function request()
    {
        return $this->hasOne(EndorsementRequest::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'request_owner_id', 'id');
    }
}
