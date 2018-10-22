<?php

namespace App\Http\Controllers;

use App\Events\DestroyPersonEvent;
use App\Events\StorePersonEvent;
use App\Events\UpdatePersonEvent;
use App\Export\Excel;
use App\Filters\People\BioDataDuplicateFilter;
use App\Filters\People\NameFilter;
use App\Filters\Shared\OnlyTrashedFilter;
use App\Filters\Shared\PageSizeFilter;
use App\Filters\Shared\PrefixFilter;
use App\Filters\Shared\SortFilter;
use App\Http\Requests\DestroyPersonRequest;
use App\Http\Requests\IndexPersonRequest;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonDataRequest;
use Carbon\Carbon;
use Grimm\Person;
use Illuminate\Http\Request;

class PersonsController extends Controller
{

    use FiltersEntity;

    /**
     * Display a listing of the resource.
     *
     * @param IndexPersonRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexPersonRequest $request)
    {
        Person::applyGrid();

        $people = Person::query();

        $this->filter($people);

        $this->preparePrefixDisplay($request->get('prefix'), Person::prefixesOfLength('last_name', 2)->get());

        $pageSize = $this->filter->filterFor('page-size')->pageSize();

        $people = $this->prepareCollection('last_person_index', $people, $request, $pageSize);

        return view('people.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePersonRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        $person = new Person();

        $this->updatePersonModel($request, $person);

        event(new StorePersonEvent($person, $request->user()));

        return redirect()->route('people.show', [$person->id])->with('success',
            'Die Person wurde erfolgreich erstellt!');
    }

    /**
     * @param IndexPersonRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \League\Flysystem\FileExistsException
     */
    public function export(IndexPersonRequest $request)
    {
        Person::applyGrid();

        $people = Person::query();

        $this->filter($people);

        $pageSize = $this->filter->filterFor('page-size')->pageSize();

        $people = $this->prepareCollection('last_person_index', $people, $request, $pageSize);

        $data = Person::activeGridData($people->items());

        $excel = new Excel();

        $file = $excel->title('Books by catalog', 0)
            ->load($data, 0, true)
            ->save('test-' . Carbon::now()->format('Ymdhis'), true);

        if ($file === null) {
            return redirect()
                ->back()
                ->with('error', 'Export konnte nicht erstellt werden!');
        }

        return response()->download($file);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = Person::withTrashed()->details()->findOrFail($id);

        return view('people.show', compact('person'));
    }

    /**
     * JSON based search via person names
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function search(Request $request)
    {
        $query = Person::searchByName($request->get('name'));

        /*
         * Sort by full text match
        $query->orderBy('last_name')
        ->orderBy('first_name');
        */

        return $query->paginate(20);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePersonDataRequest $request
     * @param Person $person
     * @return \Illuminate\Http\Response
     *
     */
    public function update(UpdatePersonDataRequest $request, Person $person)
    {
        $this->updatePersonModel($request, $person);

        event(new UpdatePersonEvent($person, $request->user()));

        return redirect()->route('people.show', [$person->id])->with('success',
            'Eintrag erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPersonRequest $request
     * @param Person $person
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(DestroyPersonRequest $request, Person $person)
    {
        $person->delete();

        event(new DestroyPersonEvent($person, $request->user()));

        return redirect()->route('people.index')->with('success', 'Die Person wurde erfolgreich gelöscht!');
    }

    /**
     * @param DestroyPersonRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(DestroyPersonRequest $request, $id)
    {
        $person = Person::onlyTrashed()->find($id);

        $person->restore();

        return redirect()->route('people.show', [$id])->with('success', 'Die Person wurde wiederhergestellt!');
    }

    /**
     * TODO: Extract this method
     *
     * @param        $request
     * @param Person $person
     */
    private function updatePersonModel(Request $request, Person $person)
    {
        $person->last_name = $request->get('last_name');
        $person->first_name = $request->get('first_name') ?: null;

        $person->birth_date = $request->get('birth_date') ?: null;
        $person->death_date = $request->get('death_date') ?: null;

        $person->bio_data = $request->get('bio_data') ?: null;
        $person->bio_data_source = $request->get('bio_data_source') ?: null;

        $person->add_bio_data = $request->get('add_bio_data') ?: null;

        $person->source = $request->get('source') ?: ''; // Source is not nullable!

        $person->is_organization = $request->get('is_organization');

        $person->auto_generated = $request->get('auto_generated');

        $person->save();
    }

    protected function filters()
    {
        return [
            new PageSizeFilter('people'),
            new NameFilter(),
            new PrefixFilter('last_name'),
            new BioDataDuplicateFilter(),
            new OnlyTrashedFilter('people'),
            new SortFilter(function ($builder, $orderByKey, $direction) {
                if (!$this->filter->applied(NameFilter::class)) {
                    $builder->orderBy('last_name', $direction)->orderBy('first_name', $direction);
                }

                return 'name';
            }),
        ];
    }
}
