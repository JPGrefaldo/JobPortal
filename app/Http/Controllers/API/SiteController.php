<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Site;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::all();

        return response()->json([
            'sites' => $sites,
        ]);
    }
}
