<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Grimm\LibraryBook;
use Spatie\MediaLibrary\Media;

class BookScansController extends Controller
{

    public function index(LibraryBook $librarybook)
    {
        return view('librarybooks.scans', [
            'book' => $librarybook
        ]);
    }

    public function show(LibraryBook $librarybook, Media $scan)
    {
        return $scan->toResponse();
    }
}