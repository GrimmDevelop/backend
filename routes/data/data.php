<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'data', 'namespace' => 'Data\\'], function () {
    Route::get('letters/{letter}', 'Letters\\LettersController@show');
});
