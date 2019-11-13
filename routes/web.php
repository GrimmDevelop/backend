<?php

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

$this->group(['middleware' => 'auth'], function () {
    $this->get('/', function () {
        return redirect('home');
    });

    $this->get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);

    // Letters
    $this->get('letters/assign/{association}', 'LettersController@assignPerson')
        ->name('letters.assign-person');
    $this->post('letters/assign/{association}', 'LettersController@doAssignPerson');

    $this->resource('letters', 'LettersController', ['except' => ['edit']]);
    $this->post('letters/export', 'LettersController@export')->name('letters.export');

    $this->get('letters/{letter}/scans/upload', 'LetterScansController@uploadGet')->name('letters.scans.upload');
    $this->post('letters/{letter}/scans/upload', 'LetterScansController@uploadPost');
    $this->resource('letters.scans', 'LetterScansController');

    $this->resource('letters.apparatuses', 'LetterApparatusesController')->only(['index']);

    $this->resource('letters.associations', 'Letters\\AssociationsController', ['except' => ['index', 'show']]);

    // Conversations
    $this->get('conversations/{letter}', 'ConversationsController@show');

    // Books
    $this->resource('books', 'BooksController', ['except' => ['edit']]);

    // Persons
    $this->get('people/search', ['as' => 'people.search', 'uses' => 'PersonsController@search']);
    $this->resource('people', 'PersonsController', ['except' => ['edit']]);

    $this->post('people/export', ['as' => 'people.export', 'uses' => 'PersonsController@export']);
    $this->post('people/{id}/restore', ['as' => 'people.restore', 'uses' => 'PersonsController@restore']);
    $this->post('books/{id}/restore', ['as' => 'books.restore', 'uses' => 'BooksController@restore']);
    $this->post('librarybooks/{id}/restore',
        ['as' => 'librarybooks.restore', 'uses' => 'LibraryBooksController@restore']);

    // Users
    $this->resource('users', 'UsersController');
    $this->resource('roles', 'RolesController', ['except' => ['edit']]);

    // Grimm Library
    $this->get('librarybooks/{book}/upload-scan', 'LibraryBooksController@uploadGet')->name('librarybooks.upload-scan');
    $this->post('librarybooks/{book}/upload-scan', 'LibraryBooksController@uploadPost');

    $this->get('librarybooks/analyze', 'LibraryBooksController@analyzeBooks')->name('librarybooks.analyze');
    $this->resource('librarybooks', 'LibraryBooksController', ['except' => ['edit']]);
    $this->post('librarybooks/export', 'LibraryBooksController@export')->name('librarybooks.export');
    $this->get('librarybooks/{book}/relation/{name}',
        ['as' => 'librarybooks.relation', 'uses' => 'LibraryBooksController@relation']);
    $this->post('librarybooks/{book}/relation/{name}', 'LibraryBooksController@storeRelation');
    $this->delete('librarybooks/{book}/relation/{name}', 'LibraryBooksController@deleteRelation');

    $this->resource('librarybooks.scans', 'Library\\BookScansController');

    $this->get('librarypeople/search', 'LibraryPeopleController@search');
    $this->resource('librarypeople', 'LibraryPeopleController', ['only' => ['index', 'show', 'store', 'update']]);
    $this->get('librarypeople/{libraryPerson}/combine',
        'LibraryPeopleController@combine')->name('librarypeople.combine');
    $this->post('librarypeople/{libraryPerson}/combine', 'LibraryPeopleController@postCombine');


    // Associations (user-book)
    $this->get('books/{book}/associations',
        ['as' => 'books.associations.index', 'uses' => 'BooksPersonController@showBook']);
    $this->post('books/{book}/associations',
        ['as' => 'books.associations.store', 'uses' => 'BooksPersonController@bookStorePerson']);

    $this->get('people/book/{association}', ['as' => 'people.book', 'uses' => 'BooksPersonController@show']);
    $this->delete('people/book/{association}',
        ['as' => 'people.book.delete', 'uses' => 'BooksPersonController@destroy']);

    $this->get('people/{person}/add-book',
        ['as' => 'people.add-book', 'uses' => 'BooksPersonController@personAddBook']);
    $this->post('people/{person}/add-book',
        ['as' => 'people.add-book.store', 'uses' => 'BooksPersonController@personStoreBook']);

    // Administration
    $this->get('admin/publish', ['as' => 'admin.deployment.index', 'uses' => 'DeploymentController@index']);

    $this->get('history/since', ['as' => 'history.since', 'uses' => 'HistoryController@since']);

    $this->get('admin/import', ['as' => 'admin.import.index', 'uses' => 'ImportController@index']);
    $this->get('admin/import/remove', 'ImportController@remove');
    $this->get('admin/import/status', 'ImportController@status');
    $this->post('admin/import/trigger', 'ImportController@trigger');

    $this->get('admin/import/upload', 'ImportController@uploadGet')
        ->name('admin.import.upload');
    $this->post('admin/import/upload', 'ImportController@uploadPost');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
