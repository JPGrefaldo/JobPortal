<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectDeniedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $producer;

    /**
     * @var Project
     */
    public $project;

    /**
     * Create a new message instance.
     *
     * @param User $producer
     * @param Project $project
     */
    public function __construct($producer, $project)
    {
        $this->producer = $producer;
        $this->project = $project;
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
