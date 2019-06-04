<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class IndexController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('index');
    }
}
