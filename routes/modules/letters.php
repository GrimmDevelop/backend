<?php

use Illuminate\Support\Facades\Route;

Route::get('letters/assign/{association}', 'LettersController@assignPerson')
    ->name('letters.assign-person');
Route::post('letters/assign/{association}', 'LettersController@doAssignPerson');

Route::resource('letters', 'LettersController')
    ->except(['edit']);
Route::post('letters/export', 'LettersController@export')
    ->name('letters.export');

Route::get('letters/{letter}/scans/upload', 'LetterScansController@uploadGet')
    ->name('letters.scans.upload');
Route::post('letters/{letter}/scans/upload', 'LetterScansController@uploadPost');
Route::resource('letters.scans', 'LetterScansController');

Route::resource('letters.apparatuses', 'LetterApparatusesController')
    ->only(['index']);

Route::resource('letters.lettertext', 'LetterTextController')->only(['index']);

Route::resource('letters.associations', 'Letters\\AssociationsController')
    ->except(['index', 'show']);
