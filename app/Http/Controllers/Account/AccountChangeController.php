<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountChangeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->roles->pluck('name')[0];
        
        if ($role == Role::CREW) {
            $user->syncRoles(Role::PRODUCER);
        }

        if ($role == Role::PRODUCER) {
            $user->syncRoles(Role::CREW);
        }

        return $user;
    }
}
