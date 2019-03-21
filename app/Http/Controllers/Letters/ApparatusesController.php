<?php

namespace App\Http\Controllers\Letters;

use App\Http\Controllers\Controller;
use App\Http\Requests\Letters\UpdateLetterApparatusRequest;
use Grimm\Letter;
use Grimm\LetterApparatus;

class ApparatusesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Letter $letter
     * @return \Grimm\LetterApparatus[]|\Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Letter $letter)
    {
        $this->authorize('letters.update');

        $apparatus = $letter->apparatus ?? LetterApparatus::query()->create([
                'entry' => '',
                'letter_id' => $letter->id
            ]);

        return fractal($apparatus, function (LetterApparatus $apparatus) {
            return [
                'id' => $apparatus->id,
                'entry' => $apparatus->entry,
            ];
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLetterApparatusRequest $request
     * @param Letter $letter
     * @param LetterApparatus $apparatus
     * @return void
     */
    public function update(UpdateLetterApparatusRequest $request, Letter $letter, LetterApparatus $apparatus)
    {
        $apparatus->entry = (string)$request->input('entry');
        $apparatus->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Letter $letter
     * @param LetterApparatus $apparatus
     * @return void
     * @throws \Exception
     */
    public function destroy(Letter $letter, LetterApparatus $apparatus)
    {
        $apparatus->delete();
    }
}
