<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountChangeController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function crew()
    {
        $this->user->syncRoles(Role::CREW);

        return $this->user;
    }

    public function producer()
    {
        $this->user->syncRoles(Role::PRODUCER);

        return $this->user;
    }
}
