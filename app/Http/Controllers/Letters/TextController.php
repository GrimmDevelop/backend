<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Letters\UpdateLetterTextRequest;
use Grimm\Letter;

class TextController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Letter $letter
     * @return \Grimm\Letter
     */
    public function index(Letter $letter)
    {
        return fractal($letter, function (Letter $letter) {
            return [
                'id' => $letter->id,
                'entry' => $letter->text,
            ];
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLetterTextRequest $request
     * @param Letter $letter
     * @return void
     */
    public function update(UpdateLetterTextRequest $request, Letter $letter)
    {
        $letter->text = (string)$request->input('entry');
        $letter->save();
    }
}
