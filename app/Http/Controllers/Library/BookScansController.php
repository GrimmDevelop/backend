<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Grimm\LibraryBook;
use Spatie\MediaLibrary\Models\Media;

class BookScansController extends Controller
{

    /**
     * @param LibraryBook $librarybook
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(LibraryBook $librarybook)
    {
        return view('librarybooks.scans', [
            'book' => $librarybook
        ]);
    }

    /**
     * @param LibraryBook $librarybook
     * @param Media $scan
     * @return \Illuminate\Http\Response
     */
    public function show(LibraryBook $librarybook, Media $scan)
    {
        return $scan->toResponse(request());
    }
}