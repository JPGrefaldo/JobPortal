<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function showTermsAndConditions()
    {
        return view('static-pages.terms');
    }

    public function showAbout()
    {
        return view('static-pages.about.index');
    }

    public function showAboutProducers()
    {
        return view('static-pages.about.producers');
    }

    public function showAboutCrew()
    {
        return view('static-pages.about.crew');
    }
}
