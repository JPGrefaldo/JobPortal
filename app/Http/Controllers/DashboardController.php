<?php

namespace App\Http\Controllers;

use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'user' => Auth::user(),
        ]);
    }
}
