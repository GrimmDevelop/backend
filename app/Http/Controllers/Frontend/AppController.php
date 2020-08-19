<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class AppController extends Controller
{

    public function index()
    {
        return view('frontend.app');
    }

    public function loader()
    {
        return view('frontend.loader');
    }
}
