<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('sign-up', 'UserController@signUp');
Route::post('sign-in', 'UserController@signIn');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('nurse', 'NurseController@get');
    Route::post('nurse', 'NurseController@create');
    Route::put('nurse/{id}', 'NurseController@update');
    Route::delete('nurse/{id}', 'NurseController@delete');
});

    // --------------------- test api--------------------
    Route::group(['prefix' => 'test'], function () {
        Route::get('/list', 'TestController@getTestList');
    });
   //---------------------- end test api-----------------

    // --------------------- turn api--------------------
    Route::group(['prefix' => 'turn'], function () {
        Route::post('/set-turn', 'TurnController@setTurn');
    });
   //---------------------- end turn api-----------------

