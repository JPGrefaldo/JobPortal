<?php

namespace App\Models;

use App\Utils\UrlUtils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrewResume extends Model
{
    /**
     * @var array
     */
    protected $appends = [
        'link',
    ];

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
        'id'               => 'integer',
        'crew_id'          => 'integer',
        'url'              => 'string',
        'general'          => 'boolean',
        'crew_position_id' => 'integer',
    ];

    /**
     * @return BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        return UrlUtils::getS3Url() . $this->attributes['path'];
    }
}
