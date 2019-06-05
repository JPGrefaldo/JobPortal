<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EndorsementRequest extends Model
{
    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id'                      => 'integer',
        'endorsement_endorser_id' => 'integer',
        'token'                   => 'string',
        'message'                 => 'string',
    ];

    /**
     * @return BelongsTo
     */
    public function endorser()
    {
        return $this->belongsTo(EndorsementEndorser::class, 'endorsement_endorser_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function endorsement()
    {
        return $this->hasOne(Endorsement::class);
    }
}
