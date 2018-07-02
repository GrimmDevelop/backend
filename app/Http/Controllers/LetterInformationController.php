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
     * @param $id
     * @return \Illuminate\Http\Response [Information[],codes[]]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        $code = new LetterCode();

        $codes = $code->all('id', 'name');

        $codes = $codes->mapWithKeys(function ($item) {
            return [$item->id => $item];
        });

        return response()->json(["information" => $letter->information, "codes" => $codes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @return Information[]\Illuminate\Http\RedirectResponse|mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Letter $letter)
    {
        $this->authorize('letters.update');

        $information = new LetterInformation();

        $information->data = $request->get('data');
        $information->letter_code_id = $request->get('code');

        $letter->Information()->save($information);

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
     * @param $informationId
     * @return LetterInformation[]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Letter $letter, $informationId)
    {

        $this->authorize('letters.update');

        /** @var Information $information */
        $informationId = $letter->information()->find($informationId);

        $informationId->data = $request->get('data');
        $informationId->letter_code_id = $request->get('code');

        $informationId->save();

        return $informationId;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param $informationId
     * @return Information []
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Letter $letter, $informationId)
    {

        $this->authorize('letters.update');

        $letter->information()->find($informationId)->delete();

        return $letter->information;
    }
}
