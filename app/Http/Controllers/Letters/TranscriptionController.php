<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\Controller;
use Grimm\Letter;
use Grimm\LetterTranscription;
use Illuminate\Http\Request;

class TranscriptionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Letter $letter
     * @return \Grimm\LetterTranscription[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        return $letter->transcriptions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return LetterTranscription[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Letter $letter)
    {
        $this->authorize('letters.update');

        $print = new LetterTranscription();
        $print->entry = $request->get('entry');
        $print->year = $request->get('year');
        $letter->transcriptions()->save($print);

        if ($request->ajax()) {
            return $letter->transcriptions;
        }

        return redirect()->route('letters.show', [$letter]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Letter $letter
     * @param $transcriptionId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasMany[]|null
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Letter $letter, $transcriptionId)
    {
        $this->authorize('letters.update');

        /** @var LetterTranscription $transcription */
        $transcription = $letter->transcriptions()->find($transcriptionId);

        $transcription->entry = $request->get('entry');
        $transcription->year = $request->get('year');

        $transcription->save();

        return $transcription;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param $transcriptionId
     * @return LetterTranscription[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Letter $letter, $transcriptionId)
    {
        $this->authorize('letters.update');

        $letter->transcriptions()->find($transcriptionId)->delete();

        return $letter->transcriptions;
    }
}
