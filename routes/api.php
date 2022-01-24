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

Route::middleware(['auth', 'role:nurse'])->group(function () {
    Route::post('user-test', 'TurnController@nurseSetTurn');
});

//Route::middleware(['auth', 'role:user'])->group(function () {
    // --------------------- test api--------------------
    Route::group(['prefix' => 'test'], function () {
        Route::get('/list', 'TestController@getTestList'); // login
    });
    //---------------------- end test api-----------------

    // --------------------- turn api--------------------
    Route::group(['prefix' => 'turn'], function () {
        Route::post('/set-turn', 'TurnController@setTurn'); // user
        Route::post('/list-turn', 'TurnController@getDoneTurn'); // user
        Route::get('/get-result/{id}', 'TurnController@getResult'); //user
    });
    Route::group(['prefix' => 'nurse/turn'], function () {
        Route::get('/all/{filter}', 'TurnController@getTests'); // nurse
        Route::post('/set-result', 'TurnController@setResult'); // nurse
    });
   //---------------------- end turn api-----------------

       // --------------------- doctor api-------------------- 
    Route::group(['prefix' => 'doctor'], function () {
        Route::get('/list', 'DoctorController@getDoctors'); // login 
    });
   //------------------------ end doctor api-----------------
    
//});
