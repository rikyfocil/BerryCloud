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
})->name('/');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/shared', 'HomeController@sharedWith')->name('shared');
Route::get('/trash', 'HomeController@trash')->name('trash');

Route::get('/users_complete', 'UsersController@usersLike');
Route::get('/users_parcial', 'UsersController@usersOnlyLike');

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

	Route::post('{file_id}/makePublic', 'FileController@makePublic')->name('file.publish');
	Route::post('{file_id}/makePrivate', 'FileController@makePrivate')->name('file.unpublish');

	Route::delete('{file_id}', 'FileController@delete')->name('file.delete');
	Route::delete('{file_id}/permanent', 'FileController@deleteHard')->name('file.delete.hard');
	Route::delete('{file_id}/version/{id_version}', 'FileController@deleteVersion')->name('file.version.delete');

	Route::group(['prefix' => '{file_id}/share'], function (){

		Route::get('/', 'FileController@sharedWith');
		Route::post('/', 'FileController@shareWith')->name('file.share.create');
		Route::delete('/{id}', 'FileController@deleteShare')->name('file.share.delete');
	});

});


Route::group(['prefix' => 'folder'], function () {

	Route::post('create', 'FileController@createFolder')->name('folder.create');

});


Route::post('{group_id}/member', 'GroupController@addMember')->name('groups.member.add');
Route::delete('{group_id}/member/{member_id}', 'GroupController@removeMember')->name('groups.member.delete');

Route::resource('groups', 'GroupController', ['except' => [
    'edit', 'create'
]]);


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    // Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
    // Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
