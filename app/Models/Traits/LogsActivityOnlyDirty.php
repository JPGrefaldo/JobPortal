<?php

namespace App\Models\Traits;

use Spatie\Activitylog\Traits\LogsActivity;

trait LogsActivityOnlyDirty
{
    use LogsActivity;

    /**
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * @var bool
     */
    protected static $logOnlyDirty = true;
}
