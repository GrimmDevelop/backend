<?php

namespace App\Http\Controllers;

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
        $letters = Letter::query();

        $letters->with(['from', 'to', 'personAssociations']);

        $this->filter($letters);

        $letters = $this->prepareCollection('last_letter_index', $letters, $request, 20);

        return view('letters.index', compact('letters'));
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
     * Display the specified resource.
     *
     * @param ShowLetterRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowLetterRequest $request, $id)
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
            new TrashFilter('letters'),
            new SortFilter(function ($builder) {
                $builder->orderBy('code');

                return 'code';
            }),
        ];
    }
}
