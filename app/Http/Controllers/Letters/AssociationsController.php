<?php

namespace App\Http\Controllers\Letters;

use App\Http\Requests\DestroyLettersAssociationsRequest;
use App\Http\Requests\StoreLettersAssociationsRequest;
use App\Http\Requests\UpdateLettersAssociationsRequest;
use Grimm\Letter;
use Grimm\LetterPersonAssociation;
use App\Http\Controllers\Controller;

class AssociationsController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param Letter $letter
     * @return \Illuminate\Http\Response
     */
    public function create(Letter $letter)
    {
        return view('letters.associations.create', compact('letter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLettersAssociationsRequest $request
     * @param Letter $letter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreLettersAssociationsRequest $request, Letter $letter)
    {
        $request->persist($letter);

        return redirect()
            ->route('letters.show', [$letter])
            ->with('success', 'Die Person wurde hinzugefügt');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Letter $letter
     * @param LetterPersonAssociation $association
     * @return \Illuminate\Http\Response
     */
    public function edit(Letter $letter, LetterPersonAssociation $association)
    {
        if ($letter->id != $association->letter_id) {
            throw new \InvalidArgumentException("letter and association do not match!");
        }

        return view('letters.associations.edit', compact('letter', 'association'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLettersAssociationsRequest $request
     * @param Letter $letter
     * @param LetterPersonAssociation $association
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        UpdateLettersAssociationsRequest $request,
        Letter $letter,
        LetterPersonAssociation $association
    ) {
        $request->persist($letter, $association);

        return redirect()
            ->route('letters.show', [$letter])
            ->with('success', 'Der Eintrag wurde gespeichert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLettersAssociationsRequest $request
     * @param Letter $letter
     * @param LetterPersonAssociation $association
     * @return void
     */
    public function destroy(
        DestroyLettersAssociationsRequest $request,
        Letter $letter,
        LetterPersonAssociation $association
    ) {
        $request->persist($letter, $association);
    }
}
