<?php

namespace App\Http\Controllers;

use App\Filters\Shared\PageSizeFilter;
use App\Filters\Shared\SortFilter;
use App\Filters\Shared\TrashFilter;
use App\Http\Requests\DestroyLetterRequest;
use App\Http\Requests\IndexBookRequest;
use App\Http\Requests\ShowLetterRequest;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use Grimm\Letter;
use Illuminate\Http\Request;

class LettersController extends Controller
{

    use FiltersEntity;

    /**
     * Display a listing of the resource.
     *
     * @param IndexBookRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexBookRequest $request)
    {
        Letter::applyGrid();

        $letters = Letter::query();

        $letters->with(['from', 'to', 'personAssociations']);

        $this->filter($letters);

        $pageSize = $this->filter->filterFor('page-size')->pageSize();

        $letters = $this->prepareCollection('last_letter_index', $letters, $request, $pageSize);

        return view('letters.index', compact('letters'));
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
        //
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLetterRequest $request, $id)
    {
        //
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
            new PageSizeFilter('letters'),
            new TrashFilter('letters'),
            new SortFilter(function ($builder, $key, $direction) {

                if ($key == 'senders') {
                    // TODO: order by senders...

                    return 'senders';
                } else {
                    $builder->orderBy('code');

                    return 'code';
                }
            }),
        ];
    }
}
