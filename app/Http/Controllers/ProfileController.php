<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\CrewReel;
use App\Models\CrewResume;
use App\Models\Position;
use App\Models\CrewSocial;
use App\Models\Department;
use App\Models\UserRoles;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Html\FormBuilder;
use Session;
use Auth;
use Intervention\Image\Facades\Image as Image;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {

    $title = UserRoles::where('user_id', $user->id)->first();
    $role = Role::where('id', $title->role_id)->first();
    $biography = Crew::where('user_id', $user->id)->first();
    $positions = CrewPosition::where('crew_id', $user->id)->first();
    $all_post = CrewPosition::where('crew_id',$user->id)->get();

    if (isset($positions)) {
    $position_role = Position::where('department_id', $positions->position_id)->first();
    }

    $fb = CrewSocial::where('social_link_type_id','=',1)
        ->where('crew_id', $user->id)
        ->first();
    $imdb = CrewSocial::where('social_link_type_id','=',5)
        ->where('crew_id', $user->id)
        ->first();
    $linkedin = CrewSocial::where('social_link_type_id','=',10)
        ->where('crew_id', $user->id)
        ->first();


    $resume = CrewResume::where('crew_id', $user->id)->first();
    if (isset($resume)) {
     $url_resume = Storage::url($resume->url);
    }

    $reel = CrewReel::where('crew_id', $user->id)->first();
    
    if (!empty($reel)) {
    $url_reel = Storage::url($reel->url);

    }
 
    return view('profile.my-profile', compact('user','role', 'biography','positions','position_role', 'fb', 'imdb', 'linkedin', 'resume', 'url_resume', 'reel','url_reel', 'all_post'));

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
    
    $biography = Crew::where('user_id', $user->id)->first();
    $position = CrewPosition::where('crew_id', $user->id)->first();
    $positions = CrewPosition::where('crew_id', $user->id)->first();

    if (isset($positions)) {
     $position_role = Position::where('department_id', $positions->position_id)->first();
    }

    if ( isset($position) ) {
    
    $jobTitle = Position::where('department_id', $position->position_id)->first();
    
    }
    
    $fb = CrewSocial::where('social_link_type_id','=',1)
        ->where('crew_id', $user->id)
        ->first();
    $imdb = CrewSocial::where('social_link_type_id','=',5)
        ->where('crew_id', $user->id)
        ->first();
    $linkedin = CrewSocial::where('social_link_type_id','=',10)
        ->where('crew_id', $user->id)
        ->first();

    $reel = CrewReel::where('crew_id', $user->id)->first();
    $resume = CrewResume::where('crew_id', $user->id)->first();

    $department = Department::first();

     return view('profile.my-profile-edit', compact('user','positions', 'position_role', 'biography', 'jobTitle', 'fb', 'imdb', 'linkedin', 'department', 'reel', 'resume')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        //set the User
        $user = User::where('id', Auth::user()->id)->first();
        $edit_user = Crew::where('user_id', $user->id)->first(); 


        // save profile image
        if ($request->hasFile('profile_image')) {
        
        $image = $request->file('profile_image');
        $filename = time() . '.' . $image->getClientOriginalExtension();   
        $location = public_path('photos/' . $filename);
        Image::make($image)->resize(400, 400)->save($location);
        $edit_user->photo = "photos/". $filename;
        }

        $edit_user->bio = $request->bio;        
        $edit_user->save();

        // save crew reel
        if ($request->hasFile('reel_file')) {

        $reel_fileName = "fileName".time().'.'.request()->reel_file->getClientOriginalExtension();
        $user_reel = Storage::putFile('reels', $request->file('reel_file'));
        $user_reel_filepath = 'reel/' . $reel_fileName;
        $save_reel = CrewReel::where('crew_id', $user->id)->first();
        $save_reel->url = $user_reel_filepath;
        $save_reel->save();
        }


        // save crew resume

        if ($request->hasFile('resume_file')) {

        $resume_fileName = $user->first_name." ".$user->last_name  ." " . "resume".time().'.'.request()->resume_file->getClientOriginalExtension();
        $user_resume = Storage::putFileAs('resume', $request->file('resume_file'),$resume_fileName);
        $resume_url = Storage::url($user_resume);
        $user_resume_filepath = 'resume/' . $resume_fileName;

        $save_resume = CrewResume::where('crew_id', $user->id)->first();
        
        if (isset($save_resume->url)) {
        $save_resume->url = $user_resume_filepath;
        $save_resume->save();            
        }
        else {
        $new_resume = new CrewResume;
        $new_resume->crew_id = $user->id;
        $new_resume->url = $user_resume_filepath;
        $new_resume->general = $user_resume_filepath;
        $new_resume->save();
         }
    
     }


        // Save Crew Position
        $edit_position = CrewPosition::where('crew_id', $user->id)->first(); 

        if ($request->title == '1st Assistant Director') {
            $edit_position_id = 1;
        } elseif ($request->title == 'Camera Operator') {
            $edit_position_id = 2;
        }

        $edit_position->position_id = $edit_position_id;
        $edit_position->save();

        // Save Crew Social
        $user_imdb = CrewSocial::where('social_link_type_id',5)
                    ->where('crew_id', $user->id)
                    ->first();

        $user_fb = CrewSocial::where('social_link_type_id',1)
                    ->where('crew_id', $user->id)
                    ->first();

        $user_linkedin = CrewSocial::where('social_link_type_id',10)
                    ->where('crew_id', $user->id)
                    ->first();

        $user_imdb->url = $request->imdb_link;
        $user_fb->url = $request->fb_link;
        $user_linkedin->url = $request->linkedin_link;

        $user_imdb->save();
        $user_fb->save();
        $user_linkedin->save();
 
        session()->flash('profile-saved ', 'Profile saved!');

        return redirect()->route('profile', ['id' => $user->id]);
    }


    public function addPositionView (Request $request) {
        
    $user = User::where('id', Auth::user()->id)->first();
    $biography = Crew::where('user_id', $user->id)->first();
    $positions = CrewPosition::where('crew_id', $user->id)->first();
    $jobTitle = Position::where('department_id', $positions->position_id)->first();
    
    return view('profile.my-profile-add-position', compact('user', 'biography','jobTitle', 'positions'));

    }

    public function addPost (Request $request) {

        $user = User::where('id', Auth::user()->id)->first();
        $crew_position = new CrewPosition;

        $crew_position->crew_id = $user->id;

        if ($request->title == '1st Assistant Director') {
            $post_id = 1;
        } else {
            $post_id = 2;
        }

        $crew_position->position_id = $post_id;

        $crew_position->details = $request->bio;

        $crew_position->union_description = $request->bio;

        $crew_position->save();

        return redirect()->route('profile', ['id' => $user->id]);

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
     
    $resume = CrewResume::find($id);
    $resume->delete();

     return redirect()->back();
     }
}
