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
	
	Route::get('{file_id}', 'FileController@show')->name('file.show');
	Route::get('{file_id}/download', 'FileController@download')->name('file.download');
	Route::post('{file_id}/restore', 'FileController@restoreFile')->name('file.restore');

	Route::get('{file_id}/version/{version_id}', 'FileController@downloadVersion')->name('file.version.download');
	Route::get('{file_id}/upload', 'FileController@uploadVersionGet')->name('uploadVersionGet');

	Route::post('{file_id}/version', 'FileController@uploadVersion')->name('uploadVersion');
	Route::post('{file_id}/version/{id_version}/restore', 'FileController@restoreVersion')->name('file.version.restore');

	Route::delete('{file_id}', 'FileController@delete')->name('file.delete');
	Route::delete('{file_id}/permanent', 'FileController@deleteHard')->name('file.delete.hard');
	Route::delete('{file_id}/version/{id_version}', 'FileController@deleteVersion')->name('file.version.delete');;
});
