<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectApprovalRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;

    public $message;

    public $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin, $message, $project)
    {
        $this->admin   = $admin;
        $this->message = $message;
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.project-approval');
    }
}
