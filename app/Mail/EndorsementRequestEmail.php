<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EndorsementRequestEmail extends Mailable
{
    public $endorsement;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($endorsement)
    {
        $this->endorsement = $endorsement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.endorsement-request-email')
            ->with('endorsement', $this->endorsement);
    }
}
