<?php

use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\MovieBroadcastController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('movies', MovieController::class)->except(["show", "update"]);
Route::get('movies/{movie}', [MovieBroadcastController::class, 'index']);

Route::apiResource('movies.broadcasts', MovieBroadcastController::class)
    ->scoped()->except(["index", "destroy", "update"]);