<?php

namespace App\Http\Controllers;

use App\Models\EmailVerificationCode;
use App\Session\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class VerifyEmailController extends Controller
{
    /**
     * Handle get request to verify from email
     *
     * @param Request $request
     * @param string $code
     *
     * @return RedirectResponse|Redirector
     */
    public function verify(Request $request, $code)
    {
        $code = EmailVerificationCode::where('code', $code)->first();
        $flashMessage = app(FlashMessage::class);

        if (! $code) {
            $flashMessage->error('Invalid confirmation code.', 'Error!');
        } elseif ($code->user->isConfirmed()) {
            $flashMessage->error('Your account was already confirmed, you do not need to confirm again.');
        } else {
            $code->user->confirm();
            $flashMessage->success('Your account has been confirmed! You may now login.');
        }

        return redirect('login');
    }
}
