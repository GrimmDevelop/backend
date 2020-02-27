<?php

// Authentication Routes...
use Illuminate\Support\Facades\Route;

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/', 'Frontend\\AppController@index')->name('frontend');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')
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
