<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Message;
use Illuminate\Database\Eloquent\Model;

class PendingFlagMessage extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'integer',
        'message_id' => 'integer',
        'reason' => 'string',
        'approved_at' => 'datetime',
        'disapproved_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
