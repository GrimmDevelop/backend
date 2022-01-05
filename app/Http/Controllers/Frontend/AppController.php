<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AbortJsonRequest;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware([AbortJsonRequest::class]);
    }

    public function index()
    {
        return view('frontend.app');
    }

    public function loader()
    {
        return view('frontend.loader');
    }
}
