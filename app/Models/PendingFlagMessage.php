<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingFlagMessage extends Model
{
    const UNAPPROVED = 0;
    const APPROVED   = 1;

    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'id'             => 'integer',
        'message_id'     => 'integer',
        'reason'         => 'string',
        'approved_at'    => 'datetime',
        'disapproved_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * @return bool
     */
    public function approve()
    {
        return $this->update(
            [
                'approved_at' => Carbon::now(),
                'status'      => static::APPROVED,
            ]
        );
    }

    /**
     * @return bool
     */
    public function disapprove()
    {
        return $this->update(
            [
                'approved_at'    => null,
                'disapproved_at' => Carbon::now(),
                'status'         => static::UNAPPROVED,
            ]
        );
    }
}
