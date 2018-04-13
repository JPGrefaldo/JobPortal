<?php

namespace App\Http\Controllers;

use App\Crew;
use App\CrewResume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrewsController extends Controller
{
    public function store(Request $request)
    {
        //@todo: add validation later
        $user = Auth::user();
        $crew = Crew::create([
            'user_id' => $user->id,
            'bio' => $request->get('bio'),
            'photo' => 'photos/' . $user->uuid. '/' . $request->file('photo')->hashName()
        ]);
        $resume = new CrewResume([
            'url' => 'resumes/' . $user->uuid . '/' . $request->file('resume')->hashName(),
            'general' => 1
        ]);
        $crew->resumes()->save($resume);

        \Storage::disk()->put($crew->photo, file_get_contents($request->file('photo')));
        \Storage::disk()->put($resume->url, file_get_contents($request->file('resume')));

        return response('');
    }
}
