<?php

namespace App\Http\Controllers;

use Grimm\Book;
use Grimm\BookPersonAssociation;
use Grimm\Person;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BooksPersonController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Person $person
     * @return \Illuminate\Http\Response
     */
    public function personAddBook(Person $person)
    {
        return view('persons.add-book', compact('person'));
    }

    /**
     * @param Person $person
     */
    public function personStoreBook(Person $person)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @param Person $person
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book, Person $person)
    {
        /** @var BookPersonAssociation $association */
        $association = BookPersonAssociation::query()
            ->with('book', 'person')
            ->where('book_id', $book->id)
            ->where('person_id', $person->id)
            ->first();

        // TODO: fancy gallery with scan of pages

        return view('books.person', compact('association'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
