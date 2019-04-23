<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsAndConditionsController extends Controller
{
    /**
     * Show the Terms and Conditions page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('termsandconditions.index');
    }
}
