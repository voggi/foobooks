<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact')->with(['email' => config('app.supportEmail')]);
    }
}
