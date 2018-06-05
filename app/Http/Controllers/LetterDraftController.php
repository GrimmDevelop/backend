<?php

namespace App\Http\Controllers;

use Grimm\Draft;
use Grimm\Letter;
use Illuminate\Http\Request;

class LetterDraftController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        return $letter->drafts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @return Draft[]|\Illuminate\Http\Response|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Letter $letter)
    {
        $this->authorize('letters.update');

        $draft = new Draft();
        $draft->entry = $request->get('entry');
        $draft->year = $request->get('year');
        $letter->drafts()->save($draft);

        if ($request->ajax()) {
            return $letter->drafts;
        }

        return redirect()->route('letters.show', ['letters' => $letter->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @param $draftId
     * @return Draft
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Letter $letter, $draftId)
    {
        $this->authorize('letters.update');

        /** @var Draft $draft */
        $draft = $letter->facsimiles()->find($draftId);

        $draft->entry = $request->get('entry');
        $draft->year = $request->get('year');

        $draft->save();

        return $draft;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param $draftId
     * @return Draft[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Letter $letter, $draftId)
    {
        $this->authorize('letters.update');

        $letter->drafts()->find($draftId)->delete();

        return $letter->drafts;
    }
}
