<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBookToPersonRequest;
use App\Http\Requests\AddPersonToBookRequest;
use Grimm\Book;
use Grimm\BookPersonAssociation;
use Grimm\Person;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BooksPersonController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param Person $person
     * @return \Illuminate\Http\Response
     */
    public function personAddBook(Request $request, Person $person)
    {
        $searchTitle = $request->get('search');

        if ($searchTitle) {
            /** @var LengthAwarePaginator $books */
            $books = Book::searchByTitle($searchTitle)->paginate(10);

            $books->appends(['search' => $request->get('search')]);
        } else {
            $books = Book::query()
                ->orderBy('title')
                ->orderBy('volume')
                ->orderBy('volume_irregular')
                ->orderBy('edition')
                ->paginate(10);
        }

        return view('people.add-book', compact('books', 'person'));
    }

    /**
     * @param AddBookToPersonRequest $request
     * @param Person $person
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function personStoreBook(AddBookToPersonRequest $request, Person $person)
    {
        $book = Book::find($request->input('book'));

        $association = $this->storeAssociation($request, $person, $book);

        return redirect()
            ->route('people.book', [$association->id])
            ->with('success', 'Verknüpfung erstellt');
    }

    /**
     * @param AddPersonToBookRequest $request
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bookStorePerson(AddPersonToBookRequest $request, Book $book)
    {
        $person = Person::findOrFail($request->input('person'));

        $this->storeAssociation($request, $person, $book);

        return redirect()
            ->route('books.show', [$book])
            ->with('success', 'Verknüpfung erstellt');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Book $book
     */
    public function show($id)
    {
        /** @var BookPersonAssociation $association */
        $association = BookPersonAssociation::withTrashed()->findOrFail($id);
        $association->load([
            'book',
            'person'
        ]);

        // TODO: fancy gallery with scan of pages

        return view('books.person', compact('association'));
    }

    public function showBook(Request $request, Book $book)
    {
        /*
        $book->load([
            'personAssociations' => function ($query) {
                return $query->orderBy('page')
                    ->orderBy('line');
            },
            'personAssociations.person' => function ($query) {
                return $query->orderBy('last_name')
                    ->orderBy('first_name');
            }
        ]);
        */

        // Take the latest 15 persons and sort them afterwards.
        // We need to touch a person if an association is added.
        // Other wise, the persons updated_at timestamp is not updated and sorting won't work.

        /** @var Collection $persons */
        $persons = Person::query()
            ->with([
                'bookAssociations' => function ($query) use ($book) {
                    return $query
                        ->where('book_id', $book->id)
                        ->orderBy('page')
                        ->orderBy('line');
                }
            ])
            ->whereHas('bookAssociations',
                function ($query) use ($book) {
                    return $query->where('book_id', $book->id);
                }
            )
            ->latest()
            ->take(15)
            ->get();

        $persons = $persons->sort(function (Person $personA, Person $personB) {
            $lastNameOrder = strcmp($personA->last_name, $personB->last_name);

            if ($lastNameOrder == 0) {
                return strcmp($personA->first_name, $personB->first_name);
            }

            return $lastNameOrder;
        });

        return view('books.associations', ['book' => $book, 'persons' => $persons]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BookPersonAssociation $association
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookPersonAssociation $association)
    {
        $bookId = $association->book_id;

        $association->forceDelete();

        return redirect()
            ->route('books.show', [$bookId])
            ->with('success', trans('associations.deleted'));
    }

    /**
     * @param Request $request
     * @param Person $person
     * @param Book $book
     * @return BookPersonAssociation
     */
    protected function storeAssociation(Request $request, Person $person, Book $book)
    {
        $association = new BookPersonAssociation();

        $association->page = $request->input('page');
        $association->page_to = $request->input('page_to') ?: null;
        $association->line = $request->input('line') ?: null;
        $association->page_description = $request->input('page_description') ?: null;

        $association->person()->associate($person);
        $association->book()->associate($book);

        $association->save();

        return $association;
    }
}
