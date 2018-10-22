<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewInheritanceToPersonRequest;
use App\Http\Requests\UpdateInheritanceRequest;
use Grimm\Person;
use Grimm\PersonInheritance;

class PersonInheritanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index($id)
    {
        $person = Person::withTrashed()->findOrFail($id);
        return $person->inheritances;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddNewInheritanceToPersonRequest $request
     * @param Person $person
     *
     * @return PersonInheritance[]|\Illuminate\Http\Response
     */
    public function store(AddNewInheritanceToPersonRequest $request, Person $person)
    {
        $inheritance = new PersonInheritance();
        $inheritance->entry = $request->get('entry');
        $person->inheritances()->save($inheritance);

        if ($request->ajax()) {
            return $person->inheritances;
        }

        return redirect()->route('people.show', ['people' => $person->id])->with('success', 'Nachlass hinzugefügt');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInheritanceRequest $request
     * @param Person $person
     * @param $inheritanceId
     *
     * @return PersonInheritance
     */
    public function update(UpdateInheritanceRequest $request, Person $person, $inheritanceId)
    {
        /** @var PersonInheritance $inheritance */
        $inheritance = $person->inheritances()->find($inheritanceId);

        $inheritance->entry = $request->get('entry');

        $inheritance->save();

        return $inheritance;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Person $person
     * @param        $inheritances
     *
     * @return PersonInheritance[]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Person $person, $inheritances)
    {
        $this->authorize('people.update');

        $person->inheritances()->find($inheritances)->delete();

        return $person->inheritances;
    }
}
