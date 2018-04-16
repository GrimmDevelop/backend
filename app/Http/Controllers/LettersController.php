<?php

namespace App\Http\Controllers;

use App\Export\Excel;
use App\Filters\Letters\CorrespondenceFilter;
use App\Filters\Shared\PageSizeFilter;
use App\Filters\Shared\SortFilter;
use App\Filters\Shared\TrashFilter;
use App\Grid\Column;
use App\Http\Requests\DestroyLetterRequest;
use App\Http\Requests\IndexLetterRequest;
use App\Http\Requests\ShowLetterRequest;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use Carbon\Carbon;
use Grimm\Letter;
use Illuminate\Support\Collection;
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

        $letters = $this->prepareCollection('last_letter_index', $letters, $request, $pageSize);

        return view('letters.index', compact('letters'));
    }

    public function export(IndexLetterRequest $request)
    {
        $letters = Letter::query();

        $this->filter($letters);

        $letters = $this->prepareCollection('excel', $letters, $request, PHP_INT_MAX);

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()
            ->route('letters.index')
            ->with('error', 'Noch nicht implementiert');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLetterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLetterRequest $request)
    {
        //
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
        $letter->code = $request->input("code");
        $letter->date = $request->input("date");
        $letter->valid = $request->input("valid");
        $letter->inc = $request->input("inc");
        $letter->couvert = $request->input("couvert");
        $letter->copy_owned = $request->input("copy_owned");
        $letter->language = $request->input("language");
        $letter->copy = $request->input("copy");
        $letter->attachment = $request->input("attachment");
        $letter->directory = $request->input("directory");
        $letter->handwriting_location = $request->input("handwriting_location");
        $letter->from_source = $request->input("from_source");
        $letter->from_date = $request->input("from_date");
        $letter->receive_annotation = $request->input("receive_annotation");
        $letter->reconstructed_from = $request->input("reconstructed_from");
        $letter->to_date = $request->input("to_date");
        $letter->reply_annotation = $request->input("reply_annotation");

        $letter->save();

        return redirect()
            ->back()
            ->with('success', trans('letters.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLetterRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyLetterRequest $request, $id)
    {
        //
    }

    protected function filters()
    {
        return [
            new CorrespondenceFilter(),
            new PageSizeFilter('letters'),
            new TrashFilter('letters'),
            new SortFilter(function ($builder, $key, $direction) {
                if ($key === 'senders' || $key === 'receivers') {
                    return $this->sortByPersonAssociation($builder, $key, $direction);
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
            ->join('letter_person', function ($join) use ($key) {
                $join->on('letters.id', '=', 'letter_person.letter_id')
                    ->where('letter_person.type', $key == 'senders' ? '0' : '1');
            })
            ->orderBy('letter_person.assignment_source', $direction)
            ->select('letters.*');

        return $key;
    }
}
