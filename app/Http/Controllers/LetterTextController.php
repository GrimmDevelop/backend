<?php

namespace App\Http\Controllers;

use Grimm\Letter;

class LetterTextController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Letter $letter
     * @return \Illuminate\Http\Response
     */
    public function index(Letter $letter)
    {
        return view('letters.letter-text.index', compact('letter'));
    }
}
