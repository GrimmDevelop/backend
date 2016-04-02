<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use Grimm\Book;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('title')
            ->orderBy('volume')
            ->orderBy('volume_irregular')
            ->orderBy('edition')
            ->paginate(150);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        $book = $request->persist();

        return redirect()
            ->route('books.show', ['id' => $book->id])
            ->with('success', trans('books.save'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::with([
            'personAssociations' => function ($query) {
                $query->orderBy('book_person.page')
                    ->orderBy('book_person.line');
            },
            'personAssociations.person',
        ])->findOrFail($id);

        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, $id)
    {
        /** @var Book $book */
        $book = Book::query()->findOrFail($id);

        $request->persist($book);

        return redirect()
            ->route('books.show', ['id' => $book->id])
            ->with('success', 'Saved changes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var Book $book */
        $book = Book::query()->findOrFail($id);

        $book->personAssociations()->delete();

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', trans('books.delete'));
    }
}
