<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrewSocial extends Model
{
    use SoftDeletes;

    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $casts = [
        'id'                  => 'integer',
        'crew_id'             => 'integer',
        'social_link_type_id' => 'integer',
        'url'                 => 'string',
    ];

    /**
     * @return BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    /**
     * social_link_types_relationship
     *
     * @return BelongsTo
     */
    public function socialLinkType()
    {
        return $this->belongsTo(SocialLinkType::class);
    }
}
