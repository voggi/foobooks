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
        return 'This is information about Foobooks';
    }

    public function contact()
    {
        return 'Questions? Email us at ' . Config::get('app.supportEmail');
    }
}
