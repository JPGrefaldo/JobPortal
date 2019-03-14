<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectThread extends Pivot
{
    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function threads()
    {
        return $this->belongsToMany(Project::class, 'project_id')
            ->using(Thread::class)
            ->as('threads')
            ->withPivot('threads');
    }
}
