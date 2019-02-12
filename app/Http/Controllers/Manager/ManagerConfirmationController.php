<?php

namespace App\Http\Controllers\Manager;

use App\Events\ManagerAdded;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerConfirmationController extends Controller
{
    public function index(User $user, $subordinate)
    {
        $manager = User::where('hash_id', $user->id)->first();
        $subordinate = User::where('hash_id', $subordinate)->first();

        $manager = Manager::where([
            'manager_id'=> $user->id,
            'subordinate_id'=> $subordinate->id
        ])->first();

        if ($manager->status == 1) {
            return redirect(route('login'))->withError('confirmed', 'You already accepted '.$subordinate->fullname.'\'s request');
        }

        $manager->update([
            'status' => 1
        ]);

        return redirect(route('login'))->with('infoMessage', 'You are now '.$subordinate->fullname.'\'s manager');
    }

    public function resend($manager)
    {
        $manager = User::findOrfail($manager);
        $subordinate = Auth::user();

        if (Manager::where([
                'manager_id'=> $manager->id,
                'subordinate_id'=> $subordinate->id
            ])
            ->where('status', 0)
            ->first()
        ) {
            event(new ManagerAdded($manager, $subordinate));
        }

        return back()->with('info', 'Sending confirmation email to the manager');
    }
}
