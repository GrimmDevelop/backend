<?php

use Illuminate\Support\Facades\Route;

Route::get('letters/{letter}/{field}', 'Frontend\\LettersController@show');
