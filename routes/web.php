<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false,
    'verify' => false,
]);

Route::domain(config('grimm.frontend'))->group(function() {
    Route::get('/', 'Frontend\\AppController@index')->name('frontend');
    Route::get('/loader', 'Frontend\\AppController@loader')->name('loader');
});

Route::group(['middleware' => 'auth', 'domain' => config('grimm.backend')], function () {
    Route::get('/', 'DashboardController@index')
        ->name('dashboard');

    include "modules/letters.php";

    // Conversations
    Route::get('conversations/{letter}', 'ConversationsController@show');

    // Books
    Route::resource('books', 'BooksController')
        ->except(['edit']);

    include "modules/people.php";

    // Users
    Route::resource('users', 'UsersController');
    Route::resource('roles', 'RolesController')
        ->except(['edit']);

    include "modules/library.php";

    // Associations (user-book)
    Route::get('books/{book}/associations', 'BooksPersonController@showBook')
        ->name('books.associations.index');
    Route::post('books/{book}/associations', 'BooksPersonController@bookStorePerson')
        ->name('books.associations.store');

    Route::get('people/book/{association}', 'BooksPersonController@show')
        ->name('people.book');
    Route::delete('people/book/{association}', 'BooksPersonController@destroy')
        ->name('people.book.delete');

    Route::get('people/{person}/add-book', 'BooksPersonController@personAddBook')
        ->name('people.add-book');
    Route::post('people/{person}/add-book', 'BooksPersonController@personStoreBook')
        ->name('people.add-book.store');

    // Administration
    Route::get('admin/publish', 'DeploymentController@index')
        ->name('admin.deployment.index');

    Route::get('history/since', 'HistoryController@since')
        ->name('history.since');

    Route::get('admin/import', 'ImportController@index')
        ->name('admin.import.index');
    Route::get('admin/import/remove', 'ImportController@remove');
    Route::get('admin/import/status', 'ImportController@status');
    Route::post('admin/import/trigger', 'ImportController@trigger');
    Route::get('admin/import/upload', 'ImportController@uploadGet')
        ->name('admin.import.upload');

    Route::post('admin/import/upload', 'ImportController@uploadPost');
});
