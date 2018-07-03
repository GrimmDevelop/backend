<?php

namespace App\Http\Controllers;

use Grimm\Letter;
use Grimm\LetterCode;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LetterCodeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return LetterCode[]|\Illuminate\Database\Eloquent\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        $code = new LetterCode();

//        return $this->codesFromInformationForLetter($letter);

        return $code->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @return LetterCode[]\Illuminate\Http\RedirectResponse|mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Letter $letter)
    {
        $this->authorize('letters.update');

        $code = new LetterCode();

        $code->name = $request->get('codeName');
        $code->error_generated = $request->get('codeErrorGenerated');
        $code->internal = $request->get('codeInternal');

        $code->save();

        if ($request->ajax()) {

            return $code->all();

        }

        return redirect()->route('letters.show', ['letters' => $letter->id]);
    }

    /**
     * * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request $request
     * @param Letter $letter
     * @param $codeId
     * @return LetterCode[]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Letter $letter, $codeId)
    {

        $this->authorize('letters.update');

        /** @var LetterCode $codeId */
        $code = new LetterCode();

        $codeId = $code->find($codeId);

        $codeId->name = $request->get('codeName');
        $codeId->error_generated = $request->get('codeErrorGenerated');
        $codeId->internal = $request->get('codeInternal');


        $codeId->save();

        if ($request->ajax()) {
            return $codeId;
        }
        return redirect()->route('letters.show', ['letters' => $letter->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param $codeId
     * @return LetterCode
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Letter $letter, $codeId)
    {

        $this->authorize('letters.update');

        $code = new LetterCode();

        $code->find($codeId)->delete();

        return $code;
    }

}
