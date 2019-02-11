<?php

namespace App\Http\Controllers\Manager;

use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManagerConfirmationController extends Controller
{
    public function index($managerId, $subordinateId)
    {
        $manager = User::where('hash_id', $managerId)->first();
        $subordinate = User::where('hash_id', $subordinateId)->first();

        $manager = Manager::where([
            'manager_id'=> $manager->id,
            'subordinate_id'=> $subordinate->id
        ])->first();

        if($manager->status == 1) {
            return redirect('login')->withError('confirmed', 'You already accepted '.$subordinate->fullname.'\'s request');
        }

        $manager->update([
            'status' => 1
        ]);

        return redirect('/login')->with('infoMessage', 'You are now '.$subordinate->fullname.'\'s manager');
    }
}
