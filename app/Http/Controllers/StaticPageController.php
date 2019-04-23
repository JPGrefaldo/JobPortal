<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Show the Terms and Conditions page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTermsAndConditions()
    {
        return view('staticpages.terms');
    }

    /**
     * Show the Terms and Conditions page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAbout()
    {
        return view('staticpages.about.index');
    }

    /**
     * Show the Terms and Conditions page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAboutProducers()
    {
        return view('staticpages.about.producers');
    }

    /**
     * Show the Terms and Conditions page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAboutCrew()
    {
        return view('staticpages.about.crew');
    }

    
}
