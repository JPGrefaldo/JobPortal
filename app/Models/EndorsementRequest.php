<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function endorser()
    {
        return $this->belongsTo(EndorsementEndorser::class, 'endorsement_endorser_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function endorsement()
    {
        return $this->hasOne(Endorsement::class);
    }

}
