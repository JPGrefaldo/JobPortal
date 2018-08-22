<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class ConfirmUserAccount extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $verificationUrl = route('verify.email', ['code' => $this->user->emailVerificationCode->code]);

        return $this->view('emails.auth.confirmAccountPlain')
            ->with(['verificationUrl' => $verificationUrl])
            ->subject('Email Confirmation for ' . Config::get('app.name'));
    }
}
