<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectThread extends Pivot
{
<<<<<<< HEAD
    //
=======
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
>>>>>>> 41a52c5... Refactor and made some small changes
}
