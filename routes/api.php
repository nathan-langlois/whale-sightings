<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/sighting/list-all', 'App\Http\Controllers\Api\SightingController@listAll');
        Route::get('/sighting/list-mine', 'App\Http\Controllers\Api\SightingController@listMine');
        Route::post('/sighting/create', 'App\Http\Controllers\Api\SightingController@create');
    });

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
