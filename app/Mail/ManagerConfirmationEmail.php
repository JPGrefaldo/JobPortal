<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManagerConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $manager;

    public $subordinate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($manager, $subordinate)
    {
        $this->manager = $manager;
        $this->subordinate = $subordinate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.manager-confirmation');
    }
}
