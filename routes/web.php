<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');
Route::get('/admin', 'App\Http\Controllers\AdminController@index')->middleware('admin')->name('admin');

Route::get('admin/login', function () {
	return view('admin.auth.login');
});

Route::post('register_action', 'App\Http\Controllers\Auth\RegisterController@registerAction')->name('register_action');
Route::get('/login/{social}','App\Http\Controllers\Auth\LoginController@socialLogin')->where('social','facebook|google');
Route::get('/login/{social}/callback','App\Http\Controllers\Auth\LoginController@SocialLoginAction')->where('social','facebook|google');

Route::group(['middleware' => ['auth','user']], function () {
	//Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

});

Route::group(['middleware' => ['auth','admin'],'prefix' => 'admin', 'as' => 'admin.'], function () {
	
	Route::resource('user', 'App\Http\Controllers\UserController');
	Route::post('/user-change-status','App\Http\Controllers\UserController@changeStatus');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::resource('country', 'App\Http\Controllers\CountryController');
	Route::resource('state', 'App\Http\Controllers\StateController');
	Route::resource('city', 'App\Http\Controllers\CityController');

	Route::get('/download/{id}/{type}', 'App\Http\Controllers\UserController@download')->name('download');
});

