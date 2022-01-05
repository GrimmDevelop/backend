<?php

// Grimm Library
use Illuminate\Support\Facades\Route;

Route::get('librarybooks/{book}/upload-scan', 'LibraryBooksController@uploadGet')
    ->name('librarybooks.upload-scan');
Route::post('librarybooks/{book}/upload-scan', 'LibraryBooksController@uploadPost');

Route::get('librarybooks/analyze', 'LibraryBooksController@analyzeBooks')
    ->name('librarybooks.analyze');
Route::resource('librarybooks', 'LibraryBooksController')
    ->except(['edit']);
Route::post('librarybooks/export', 'LibraryBooksController@export')
    ->name('librarybooks.export');
Route::get('librarybooks/{book}/relation/{name}', 'LibraryBooksController@relation')
    ->name('librarybooks.relation');
Route::post('librarybooks/{book}/relation/{name}', 'LibraryBooksController@storeRelation');
Route::delete('librarybooks/{book}/relation/{name}', 'LibraryBooksController@deleteRelation');

Route::resource('librarybooks.scans', 'Library\\BookScansController');

Route::get('librarypeople/search', 'LibraryPeopleController@search');
Route::resource('librarypeople', 'LibraryPeopleController')
    ->only(['index', 'show', 'store', 'update']);
Route::get('librarypeople/{libraryPerson}/combine', 'LibraryPeopleController@combine')
    ->name('librarypeople.combine');
Route::post('librarypeople/{libraryPerson}/combine', 'LibraryPeopleController@postCombine');
