<?php

namespace App\Http\Controllers;

class MessagesDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $roles = $user->roles->pluck('name');
        return view('messages-dashboard', compact('user', 'roles'));
    }
}
