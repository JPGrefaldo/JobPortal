<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrewSocial extends Model
{
    protected $table = 'crew_social';

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
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    /**
     * social_link_types_relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function socialLinkType()
    {
        return $this->belongsTo(SocialLinkType::class);
    }
}
