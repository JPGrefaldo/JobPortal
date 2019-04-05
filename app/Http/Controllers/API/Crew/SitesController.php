<?php

namespace App\Http\Controllers\API\Crew;

use App\Http\Controllers\Controller;
use App\Models\Site;

class SitesController extends Controller
{
    public function index()
    {
        $sites = Site::all();

        return response()->json([
            'sites' => $sites
        ]);
    }
}
