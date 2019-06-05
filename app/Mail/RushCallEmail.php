<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RushCallEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $crew;

    public $projectJob;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($crew, $projectJob)
    {
        $this->crew = $crew;
        $this->projectJob = $projectJob;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.rush-call');
    }
}
