<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\CrewSocial;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Html\FormBuilder;
use Session;
use Intervention\Image\Facades\Image as Image;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    $user = User::first();
    $biography = Crew::first();
    $position = CrewPosition::first();
    $jobTitle = Position::first();
    $fb = CrewSocial::where('social_link_type_id','=',1)->first();
    $imdb = CrewSocial::where('social_link_type_id','=',5)->first();
    $department = Department::first();
 
    return view('profile.my-profile', compact('user','position', 'jobTitle', 'fb', 'imdb', 'department','biography'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
    
    $user = User::first();
    $biography = Crew::first();
    $position = CrewPosition::first();
    $jobTitle = Position::first();
    $fb = CrewSocial::where('social_link_type_id','=',1)->first();
    $imdb = CrewSocial::where('social_link_type_id','=',5)->first();
    $linkedin = CrewSocial::where('social_link_type_id','=',10)->first();
    $department = Department::first();

     return view('profile.my-profile-edit', compact('user','position', 'biography', 'jobTitle', 'fb', 'imdb', 'linkedin', 'department')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
        $user = Crew::first();

        if ($request->hasFile('profile_image')) {
        
        $image = $request->file('profile_image');
        $filename = 'profile_' . time() . $user->user_id . '.' . $image->getClientOriginalExtension();   
        $location = public_path('photos/' . $filename);
        Image::make($image)->resize(400, 400)->save($location);
        $user->photo = "photos/". $filename;

        }

        $user->bio = $request->bio;        
        $user->save();

        // Crew Position
        $position = CrewPosition::first();

        if ($request->title = '1st Assistant Director') {
            $title = 1;
        } else {
            $title = 2;
        }
        
        $position->position_id = $title;
        $position->save();

        // Crew Social
        $user_imdb = CrewSocial::where('social_link_type_id',5)->first();
        $user_fb = CrewSocial::where('social_link_type_id',1)->first();
        $user_linkedin = CrewSocial::where('social_link_type_id',10)->first();

        $user_imdb->url = $request->imdb_link;
        $user_fb->url = $request->fb_link;
        $user_linkedin->url = $request->linkedin_link;

        $user_imdb->save();
        $user_fb->save();
        $user_linkedin->save();


 
        Session::flash('success', 'Profile saved!');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
