<?php

use Illuminate\Support\Facades\Route;

// no welcome page for now
Route::redirect('/', '/api/movies');

// Just in case if someone tries to access api without /api prefix
Route::redirect('/movies', '/api/movies');
Route::redirect('/movies/{movie}', '/api/movies/{movie}');
Route::redirect('/movies/{movie}/broadcasts', '/api/movies/{movie}/broadcasts');
