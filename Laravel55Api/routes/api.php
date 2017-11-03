<?php

Use App\Player;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('players/import', 'PlayerController@import');
Route::match(['get', 'post'], 'players/import', 'PlayerController@import');

Route::resource('players', 'PlayerController');
