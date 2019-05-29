<?php

namespace App\Models;

use App\Utils\UrlUtils;
use Illuminate\Database\Eloquent\Model;

class CrewReel extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $appends = [
        'link',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id'               => 'integer',
        'crew_id'          => 'integer',
        'url'              => 'string',
        'general'          => 'boolean',
        'crew_position_id' => 'integer',
        'path'             => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    /**
     * @param $value
     */
    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = (is_null($value) ? '' : $value);
    }

    /**
     * @param $value
     */
    public function setGeneralAttribute($value)
    {
        $this->attributes['general'] = (is_null($value) ? '' : $value);
    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        if (strpos($this->attributes['path'], 'https') !== false) {
            return $this->attributes['path'];
        }

        return UrlUtils::getS3Url() . $this->attributes['path'];
    }
}
