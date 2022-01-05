<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'data', 'namespace' => 'Data\\'], function () {
    Route::get('letters', 'Letters\\LettersController@index');
    Route::get('letters/{letter}', 'Letters\\LettersController@show');
});
