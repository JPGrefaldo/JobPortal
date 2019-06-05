<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectThread extends Pivot
{
    /**
     * @return BelongsToMany
     */
    public function threads()
    {
        return $this->belongsToMany(Project::class, 'project_id')
            ->using(Thread::class)
            ->as('threads')
            ->withPivot('threads');
    }
}
