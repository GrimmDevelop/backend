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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $take = max(min((int)$request->get('take', 4), 50), 0);
        $latestLettersCreated = Letter::query()->latest()->take($take)->get();
        $latestPeopleCreated = Person::query()->latest()->take($take)->get();
        $latestBooksCreated = Book::query()->latest()->take($take)->get();
        $latestLibraryBooksCreated = LibraryBook::query()->latest()->take($take)->get();
        $latestPeopleUpdated = Person::query()->orderBy('updated_at', 'desc')->take($take)->get();
        $latestBooksUpdated = Book::query()->orderBy('updated_at', 'desc')->take($take)->get();

        return view(
            'dashboard',
            compact('latestLettersCreated', 'latestPeopleCreated', 'latestBooksCreated', 'latestLibraryBooksCreated',
                'latestPeopleUpdated',
                'latestBooksUpdated')
        );
    }
}
