<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonReferenceRequest;
use Grimm\Person;
use Grimm\PersonReference;
use Illuminate\Http\Request;

class PersonReferenceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $person
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index($person)
    {
        $this->authorize('people.*');

        /** @var Person $person */
        $person = Person::withTrashed()->findOrFail($person);

        return $person->references()->with('reference')->get();
    }

    /**
     * @param StorePersonReferenceRequest $request
     * @param Person $person
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function store(StorePersonReferenceRequest $request, Person $person)
    {
        $reference = new PersonReference();

        $reference->reference()->associate($request->input('reference'));
        $reference->notes = (string)$request->input('notes');

        $person->references()->save($reference);

        return $person->references()->with('reference')->get();
    }

    /**
     * @param Request $request
     * @param PersonReference $reference
     */
    public function destroy(Request $request, PersonReference $reference)
    {
        // be able to delete both directions
    }
}
