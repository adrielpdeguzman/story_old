<?php

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return response()->json(['name' => $request->user()->name]);
    })->name('user');

    Route::group(['prefix' => '/users', 'as' => 'users.'], function () {
        Route::get('{user}/partner', 'UserController@showPartner')
            ->name('partner.show');
        Route::put('{user}/partner', 'UserController@updatePartner')
            ->name('partner.update');
    });

    Route::resource('users', 'UserController', ['except' => [
        'create', 'edit'
    ]]);

    Route::resource('users.stories', 'StoryController', ['except' => [
        'create', 'edit'
    ]]);
});
