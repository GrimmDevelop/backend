<?php

namespace App\Http\Controllers;

use Grimm\Facsimile;
use Grimm\Letter;
use Illuminate\Http\Request;

class LetterFacsimileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index($id)
    {
        $this->authorize('letters.update');

        $letter = Letter::withTrashed()->findOrFail($id);

        return $letter->facsimiles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @return Facsimile[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Letter $letter)
    {
        $this->authorize('letters.update');

        $facsimile = new Facsimile();
        $facsimile->entry = $request->get('entry');
        $facsimile->year = $request->get('year');
        $letter->facsimiles()->save($facsimile);

        if ($request->ajax()) {
            return $letter->facsimiles;
        }

        return redirect()->route('letters.show', ['letters' => $letter->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @param $facsimileId
     * @return Facsimile
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Letter $letter, $facsimileId)
    {
        $this->authorize('letters.update');

        /** @var Facsimile $facsimile */
        $facsimile = $letter->facsimiles()->find($facsimileId);

        $facsimile->entry = $request->get('entry');
        $facsimile->year = $request->get('year');

        $facsimile->save();

        return $facsimile;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param $facsimileId
     * @return Facsimile[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Letter $letter, $facsimileId)
    {
        $this->authorize('letters.update');

        $letter->facsimiles()->find($facsimileId)->delete();

        return $letter->facsimiles;
    }
}
