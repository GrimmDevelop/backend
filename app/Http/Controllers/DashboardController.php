<?php

namespace App\Http\Controllers;

use Grimm\Book;
use Grimm\Letter;
use Grimm\LibraryBook;
use Grimm\Person;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $take = max(min((int)$request->get('take', 4), 50), 0);

        $latestLettersCreated = Letter::latest()->take($take)->get();
        $latestPeopleCreated = Person::latest()->take($take)->get();
        $latestBooksCreated = Book::latest()->take($take)->get();
        $latestLibraryBooksCreated = LibraryBook::latest()->take($take)->get();

        $latestPeopleUpdated = Person::orderBy('updated_at', 'desc')->take($take)->get();
        $latestBooksUpdated = Book::orderBy('updated_at', 'desc')->take($take)->get();

        return view(
            'dashboard',
            compact('latestLettersCreated', 'latestPeopleCreated', 'latestBooksCreated', 'latestLibraryBooksCreated', 'latestPeopleUpdated',
                'latestBooksUpdated')
        );
    }
}
