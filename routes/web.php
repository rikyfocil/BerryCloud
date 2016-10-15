<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'file'], function () {
  
	Route::get('upload', 'FileController@uploadForm')->name('uploadGet');
	Route::post('upload', 'FileController@upload')->name('upload');
	
	Route::get('{file_id}', 'FileController@show')->name('showFile');
	Route::get('{file_id}/download', 'FileController@download')->name('download');

	Route::get('{file_id}/version/{version_id}', 'FileController@downloadVersion');
	Route::post('{file_id}/version', 'FileController@uploadVersion');

	Route::delete('{file_id}', 'FileController@delete');
	Route::delete('{file_id}/permanent', 'FileController@deleteHard');
	Route::delete('{file_id}/version/{id_version}', 'FileController@deleteVersion');
});
