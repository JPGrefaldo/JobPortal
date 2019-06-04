<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AccountSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('account.account', [
            'user'        => Auth::user(),
            'accountType' => 'subscription',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (! $request->has('stripeToken')) {
            return back()->withErrors(['Invalid credit card information']);
        }

        Auth::user()->newSubscription('default', config('services.stripe.plan'))
            ->create($request->get('stripeToken'), [
                'email' => Auth::user()->email,
                'name'  => Auth::user()->full_name,
            ]);

        return back()->with('infoMessage', 'Subscribed');
    }

    /**
     * Display the specified resource.
     *
     * @param int $invoiceId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($invoiceId)
    {
        return Auth::user()->downloadInvoice($invoiceId, [
            'vendor'  => config('app.name'),
            'product' => 'Monthly Subscription',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update()
    {
        Auth::user()->subscription()->resume();

        return back()->with('infoMessage', 'Subscription Resumed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy()
    {
        Auth::user()->subscription()->cancel();

        return redirect(route('account.subscription'))->with('infoMessage', 'Unsubscribed');
    }
}
