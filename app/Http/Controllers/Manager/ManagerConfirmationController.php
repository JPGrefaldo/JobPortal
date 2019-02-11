<?php

namespace App\Http\Controllers\Manager;

use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        if($manager->status == 1) {
            return redirect(route('login'))->withError('confirmed', 'You already accepted '.$subordinate->fullname.'\'s request');
        }

        $manager->update([
            'status' => 1
        ]);

        return redirect(route('login'))->with('infoMessage', 'You are now '.$subordinate->fullname.'\'s manager');
    }
}
