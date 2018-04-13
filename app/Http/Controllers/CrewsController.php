<?php

namespace App\Http\Controllers;

use App\Crew;
use App\CrewResume;
use App\Services\CrewsServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrewsController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'bio'    => 'required|string',
            'photo'  => 'required|image',
            'resume' => 'sometimes|file|mimes:pdf,doc,docx',
        ]);

        app(CrewsServices::class)->processCreate($data, Auth::user());

        return response('');
    }
}
