<?php

namespace App\Http\Controllers\Account;

use App\Actions\Manager\CreateManager;
use App\Actions\Manager\DeleteManager;
use App\Actions\Manager\UpdateManager;
use App\Actions\User\IsUserRegistered;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\User;
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
        
        if (! $manager = app(IsUserRegistered::class)->execute($email)) {
            return back()->withErrors(['unregistered_email' => 'Make sure the email address is already registered.']);
        }

        if ($manager->id == $user->id) {
            return back()->withErrors(['own_email' => 'You have entered your own email address.']);
        }

        if (Manager::where('subordinate_id', $user->id)->first()) {
            $email = $manager->email;
            app(UpdateManager::class)->execute($user, $manager->id);
            
            return back();
        }
        
        app(CreateManager::class)->execute($manager->id, $user->id);

        return back();
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
    public function destroy($manager)
    {
        $manager = User::findOrfail($manager)->first();
        $subordinate = Auth::user();

        app(DeleteManager::class)->execute($manager, $subordinate);
    }
}
