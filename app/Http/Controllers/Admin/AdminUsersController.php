<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\Admin\AdminUsersServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUsersController extends Controller
{
    /**
     * @param Request $request
     * @param User $user
     */
    public function updateBan(Request $request, User $user)
    {
        $data = $request->validate([
            'reason' => 'required|string',
        ]);

        app(AdminUsersServices::class)->ban($data['reason'], $user);
    }
}
