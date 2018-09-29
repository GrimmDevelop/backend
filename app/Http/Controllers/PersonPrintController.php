<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewPrintToPersonRequest;
use App\Http\Requests\UpdatePrintRequest;
use Grimm\Person;
use Grimm\PersonPrint;

class PersonPrintController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Person $person
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index($person)
    {
        $this->authorize('people.*');

        $person = Person::withTrashed()->findOrFail($person);

        return $person->prints;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddNewPrintToPersonRequest $request
     * @param Person $person
     *
     * @return PersonPrint[]
     */
    public function store(AddNewPrintToPersonRequest $request, Person $person)
    {
        $print = new PersonPrint();
        $print->entry = $request->get('entry');
        $print->year = $request->get('year');
        $person->prints()->save($print);

        if ($request->ajax()) {
            return $person->prints;
        }

        return redirect()->route('people.show', ['people' => $person->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param Person $person
     * @param $printId
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Person $person, $printId)
    {
        $this->authorize('people.*');

        return $person->prints()->findOrFail($printId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePrintRequest $request
     * @param Person $person
     * @param $printId
     *
     * @return PersonPrint
     */
    public function update(UpdatePrintRequest $request, Person $person, $printId)
    {
        /** @var PersonPrint $print */
        $print = $person->prints()->find($printId);

        $print->entry = $request->get('entry');
        $print->year = $request->get('year');

        $print->save();

        return $print;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Person $person
     * @param $printId
     *
     * @return PersonPrint[]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Person $person, $printId)
    {
        $this->authorize('people.update');

        $person->prints()->find($printId)->delete();

        return $person->prints;
    }
}
