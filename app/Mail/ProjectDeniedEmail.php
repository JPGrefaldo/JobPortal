<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectDeniedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\User
     */
    public $producer;

    /**
     * @var \App\Models\Project
     */
    public $project;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $producer
     * @param \App\Models\Project $project
     */
    public function __construct($producer, $project)
    {
        $this->producer = $producer;
        $this->project  = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.project-denied');
    }
}
