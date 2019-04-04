<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectApproveRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;

    public $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin, $project)
    {
        $this->admin   = $admin;
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.project-approve');
    }
}
