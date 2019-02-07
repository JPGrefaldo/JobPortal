<?php

namespace App\Http\Controllers\Account;

use App\Actions\Manager\CheckManagerIsRegistered;
use App\Actions\Manager\CreateManager;
use App\Actions\Manager\UpdateManager;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.account', [
            'user' => Auth::user(),
            'manager' => Auth::user()->manager(),
            'accountType' => 'manager',
        ]);
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
        $email = $request['email'];
        $user = Auth::user();
        
        if ($manager = app(CheckManagerIsRegistered::class)->execute($email)){

            if($manager->id != $user->id) {
            
                if(Manager::where('subordinate_id', $user->id)->first()) {
                    app(UpdateManager::class)->execute($user, $manager->id);
                }
                
                app(CreateManager::class)->execute($manager->id, $user->id);

                return back();
            }

            return back()->withErrors(['You have entered your own email address']);
        }

        return back()->withErrors(['Make sure the email address is already registered.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
