<?php

namespace App\Http\Controllers;

class MessagesDashboardController extends Controller
{
    public function index()
    {
        $roles = auth()->user()->roles->pluck('name');

        return view('messages-dashboard', compact('roles'));
    }
}
