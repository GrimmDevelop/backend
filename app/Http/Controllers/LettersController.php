<?php

namespace App\Http\Controllers;

use App\Events\UpdateLetterEvent;
use App\Export\Excel;
use App\Filters\Letters\CorrespondenceFilter;
use App\Filters\Shared\PageSizeFilter;
use App\Filters\Shared\SearchFilter;
use App\Filters\Shared\SortFilter;
use App\Filters\Shared\TrashFilter;
use App\Http\Requests\AssignPersonToLetterRequest;
use App\Http\Requests\DestroyLetterRequest;
use App\Http\Requests\IndexLetterRequest;
use App\Http\Requests\ShowLetterRequest;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use Carbon\Carbon;
use Grimm\Letter;
use Grimm\LetterCode;
use Grimm\LetterPersonAssociation;
use Grimm\Person;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\Flysystem\FileExistsException;

class LettersController extends Controller
{

    use FiltersEntity;

    /**
     * Display a listing of the resource.
     *
     * @param IndexLetterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexLetterRequest $request)
    {
        Letter::applyGrid();

        $letters = Letter::query();

        $letters->with(['from', 'to', 'personAssociations']);

        $this->filter($letters);

        $pageSize = $this->filter->filterFor('page-size')->pageSize();

        $exportLimitExceeded = $letters->count() > 5000;

        $letters = $this->prepareCollection('last_letter_index', $letters, $request, $pageSize);

        return view('letters.index', compact('letters', 'exportLimitExceeded'));
    }

    public function export(IndexLetterRequest $request)
    {
        $letters = Letter::query();

        $this->filter($letters);

        $letters = $this->prepareCollection('excel', $letters, $request, 5000);

        $excel = new Excel();

        $data = collect();

        $data[] = Letter::translatedColumns();

        /** @var Collection $data */
        $data = $data->merge(Letter::gridStatic()->data($letters->items()));

        try {
            $excel->title('Letters', 0)
                ->load($data, 0, false);

            $file = $excel->save('letters-' . Carbon::now()->format('Ymdhis'), true);

            if ($file !== null) {
                return response()
                    ->download($file);
            }
        } catch (FileExistsException $e) {
        }

        return redirect()
            ->back()
            ->with('error', 'Export konnte nicht erstellt werden!');
    }

    /**
     * Display the specified resource.
     *
     * @param ShowLetterRequest $request
     * @param Letter $letter
     * @return \Illuminate\Http\Response
     */
    public function show(ShowLetterRequest $request, Letter $letter)
    {
        // TODO: add way to customize letter view

        return view('letters.show', compact('letter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('letters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLetterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLetterRequest $request)
    {
        $letter = $request->persist();

        return redirect()
            ->route('letters.update', [$letter])
            ->with('success', 'Der Brief wurde angelegt. Er kann nun weiter bearbeitet werden.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLetterRequest $request
     * @param Letter $letter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateLetterRequest $request, Letter $letter)
    {
        $request->persist($letter);

        event(new UpdateLetterEvent($letter, $request->user()));

        return redirect()
            ->back()
            ->with('success', trans('letters.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLetterRequest $request
     * @param Letter $letter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyLetterRequest $request, Letter $letter)
    {
        $request->persist($letter);

        return redirect()
            ->route('letters.index')
            ->with('success', trans('letters.deleted_success'));
    }

    /**
     * @param IndexLetterRequest $request
     * @param LetterPersonAssociation $association
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignPerson(IndexLetterRequest $request, LetterPersonAssociation $association)
    {
        $letter = $association->letter;

        /** @var Collection $people */
        $people = Person::query()
            ->with('letterAssociations')
            ->whereHas('letterAssociations')
            ->latest('updated_at')
            ->take(5)
            ->get();

        $people = $people->sort(function (Person $personA, Person $personB) {
            $lastNameOrder = strcmp($personA->last_name, $personB->last_name);

            if ($lastNameOrder == 0) {
                return strcmp($personA->first_name, $personB->first_name);
            }

            return $lastNameOrder;
        });

        return view('letters.assign-person', compact('letter', 'association', 'people'));
    }

    public function doAssignPerson(AssignPersonToLetterRequest $request, LetterPersonAssociation $association)
    {
        $request->persist($association);

        return redirect()
            ->route('letters.show', [$association->letter])
            ->with('success', 'Verknüpfung erstellt');
    }

    protected function filters()
    {
        return [
            new CorrespondenceFilter(),
            new SearchFilter(),
            new PageSizeFilter('letters'),
            new TrashFilter('letters'),
            new SortFilter(function ($builder, $key, $direction) {
                if ($key === 'senders' || $key === 'receivers') {
                    return $this->sortByPersonAssociation($builder, $key, $direction);
                }

                if (in_array($key, ['prints', 'transcriptions', 'drafts', 'facsimiles', 'attachments'])) {
                    return $this->sortByEntryAssociation($builder, $key, $direction);
                }

                if (Str::startsWith($key, 'code_')) {
                    return $this->sortByLetterInformation($builder, $key, $direction);
                }

                // default order: letter code
                $builder->orderBy('code');

                return 'code';
            }),
        ];
    }

    protected function sortByPersonAssociation($builder, $key, $direction)
    {
        $builder
            ->leftJoin('letter_person', function ($join) use ($key) {
                $join->on('letters.id', '=', 'letter_person.letter_id')
                    ->where('letter_person.type', $key == 'senders' ? '0' : '1');
            })
            ->orderBy('letter_person.assignment_source', $direction)
            ->select('letters.*');

        return $key;
    }

    private function sortByEntryAssociation($builder, $key, $direction)
    {
        $table = $key;

        if ($key == 'prints' || $key == 'transcriptions' || $key == 'attachments') {
            $table = 'letter_' . $key;
        }

        $builder
            ->leftJoin($table, function ($join) use ($table) {
                $join->on('letters.id', '=', $table . '.letter_id');
            })
            ->orderBy($table . '.entry', $direction)
            ->select('letters.*');

        return $key;
    }

    private function sortByLetterInformation($builder, $key, $direction)
    {
        $name = Str::replaceFirst('code_', '', $key);

        $code = LetterCode::whereName($name)->first();

        $builder
            ->leftJoin('letter_informations', function ($join) use ($code) {
                $join->on('letters.id', '=', 'letter_informations.letter_id')
                    ->where('letter_informations.letter_code_id', $code->id);
            })
            ->orderBy('letter_informations.data', $direction)
            ->select('letters.*');
    }
}
