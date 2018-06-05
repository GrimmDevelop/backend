<?php

namespace App\Http\Controllers;

use Grimm\Letter;
use Grimm\LetterPrint;
use Illuminate\Http\Request;

class LetterPrintController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $letter
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        return $letter->prints;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Letter $letter)
    {
        $this->authorize('letters.update');

        $print = new LetterPrint();
        $print->entry = $request->get('entry');
        $print->year = $request->get('year');
        $letter->prints()->save($print);

        if ($request->ajax()) {
            return $letter->prints;
        }

        return redirect()->route('letters.show', [$letter]);
    }

    /**
     * Display the specified resource.
     *
     * @param Letter $letter
     * @param $printId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Letter $letter, $printId)
    {
        $this->authorize('letters.update');

        return $letter->prints()->findOrFail($printId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @param $printId
     * @return LetterPrint
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Letter $letter, $printId)
    {
        $this->authorize('letters.update');

        /** @var LetterPrint $print */
        $print = $letter->prints()->find($printId);

        $print->entry = $request->get('entry');
        $print->year = $request->get('year');

        $print->save();

        return $print;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param $printId
     * @return LetterPrint[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Letter $letter, $printId)
    {
        $this->authorize('letters.update');

        $letter->prints()->find($printId)->delete();

        return $letter->prints;
    }
}
