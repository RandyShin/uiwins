<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('list.index');

    Route::get('/', 'BalanceController@index');

    Route::get('excel', 'BalanceController@excel');

    Route::get('process', 'BalanceController@process');

    Route::resource('deposit','DepositController');

// for logout link
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


//DB::listen(function ($query){
//
//    var_dump($query->sql);
//
//});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


route::get('/test', 'BalanceController@getBillsec');