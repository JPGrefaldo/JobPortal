<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\BanUser;
use App\Models\User;
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

        app(BanUser::class)->execute($data['reason'], $user);
    }
}
