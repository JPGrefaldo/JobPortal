<?php

namespace App\Events;

use App\Models\Project;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectDenied
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Project
     */
    public $project;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }
}
