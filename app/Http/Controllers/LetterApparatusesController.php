<?php

namespace App\Http\Controllers;

use Grimm\Letter;

class LetterApparatusesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Letter $letter
     * @return \Illuminate\Http\Response
     */
    public function index(Letter $letter)
    {
        return view('letters.apparatuses.index', compact('letter'));
    }
}
