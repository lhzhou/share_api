<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['api']], function () {
    Route::post('/Account/Register', 'Users\AccountController@register');

    Route::post('/Account/Login', 'Users\AccountController@login');
    Route::post('/Account/Info', 'Users\AccountController@info');

    Route::post('/Account/Lower', 'Users\AccountController@lower');

    Route::post('/Account/ChangePassword', 'Users\AccountController@changePassword');

    Route::post('/Wallet/Balance', 'Users\WalletController@balance');
    Route::post('/Wallet/Withdrawals', 'Users\WalletController@withdrawals');
    Route::post('/Wallet/Withdrawals/Log', 'Users\WalletController@withdrawalsLog');
    Route::post('/Wallet/Increase', 'Users\WalletController@increase');



});
