<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Mail\ManagerConfirmationEmail;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ManagerConfirmationController extends Controller
{
    public function index(User $user, $subordinate)
    {
        $manager = User::where('hash_id', $user->id)->first();
        $subordinate = User::where('hash_id', $subordinate)->first();

        $manager = Manager::where([
            'manager_id'    => $user->id,
            'subordinate_id'=> $subordinate->id,
        ])->first();

        if ($manager->status == 1) {
            return redirect(route('login'))->withError('confirmed', 'You already accepted '.$subordinate->fullname.'\'s request');
        }

        $manager->update([
            'status' => 1,
        ]);

        return redirect(route('login'))->with('infoMessage', 'You are now '.$subordinate->fullname.'\'s manager');
    }

    public function resend($manager)
    {
        $manager = User::findOrfail($manager);
        $subordinate = Auth::user();

        if (Manager::where([
            'manager_id'=> $manager->id,
            'subordinate_id'=> $subordinate->id,
        ])
            ->where('status', 0)
            ->first()
        ) {
            Mail::to($manager->email)->send(
                new ManagerConfirmationEmail($manager, $subordinate)
            );
        }

        return back()->with('info', 'Sending confirmation email to the manager');
    }
}
