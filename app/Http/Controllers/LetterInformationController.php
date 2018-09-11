<?php

namespace App\Http\Controllers;

use Grimm\Letter;
use Grimm\LetterCode;
use Grimm\LetterInformation;
use Illuminate\Http\Request;

class LetterInformationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Letter $letter
     * @return LetterInformation[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        return $letter->information;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @return LetterInformation[]\Illuminate\Http\RedirectResponse|mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Letter $letter)
    {
        $this->authorize('letters.update');

        $information = new LetterInformation();

        $information->data = $request->get('data');
        $information->letter_code_id = $request->get('code');

        $letter->information()->save($information);

        if ($request->ajax()) {
            return $letter->information;
        }

        return redirect()->route('letters.show', ['letters' => $letter->id]);
    }

    /**
     * * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request $request
     * @param Letter $letter
     * @param LetterInformation $information
     * @return LetterInformation
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Letter $letter, LetterInformation $information)
    {
        $this->authorize('letters.update');

        $information->data = $request->get('data');
        $information->letter_code_id = $request->get('code');

        $information->save();

        return $information;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param $informationId
     * @return LetterInformation[]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Letter $letter, $informationId)
    {
        $this->authorize('letters.update');

        $letter->information()->find($informationId)->delete();

        return $letter->information;
    }
}
