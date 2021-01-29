<?php


namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use Grimm\Letter;

class LettersController extends Controller
{

    public function show(Letter $letter, $field)
    {
        if ($field === 'text') {
            return view('frontend.window', [
                'component' => 'letter-text',
                'params' => [
                    'letter' => $letter,
                ]
            ]);
        }
    }
}