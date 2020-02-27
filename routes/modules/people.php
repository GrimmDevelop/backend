<?php

use Illuminate\Support\Facades\Route;

Route::get('people/search', 'PersonsController@search')
    ->name('people.search');
Route::resource('people', 'PersonsController')
    ->except(['edit']);

Route::post('people/export', 'PersonsController@export')
    ->name('people.export');
Route::post('people/{id}/restore', 'PersonsController@restore')
    ->name('people.restore');
Route::post('books/{id}/restore', 'BooksController@restore')
    ->name('books.restore');
Route::post('librarybooks/{id}/restore', 'LibraryBooksController@restore')
    ->name('librarybooks.restore');
