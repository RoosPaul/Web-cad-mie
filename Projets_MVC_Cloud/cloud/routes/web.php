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
Route::get('dropzone', 'DropzoneController@index');
Route::post('dropzone/uploadFiles', 'DropzoneController@uploadFiles');

Route::get('/home', 'HomeController@index');
Route::post('/home', 'HomeController@index');
Route::get('/contact', 'HomeController@contact');
Route::post('/contact', 'HomeController@contact');

Route::get('/', 'HomeController@index');
Route::post('/', 'HomeController@index');
Route::get('/files/{id}/delete', 'FilesController@destroy');
Route::get('/files/{id}/edit', 'FilesController@edit');
Route::post('/files/{id}/edit', 'FilesController@edit');
Route::get('/files/update', 'FilesController@add_dir');
Route::post('/files/delete_dir', 'FilesController@delete_dir');
Route::post('/files/move_dir', 'FilesController@move_dir');
Route::get('/files/share', 'FilesController@share');
Route::post('/files/share', 'FilesController@share');
Route::resource('share', 'ShareController');
Route::resource('files', 'FilesController');

Route::get('admin/files', 'AdminController@files');
Route::get('admin/users', 'AdminController@users');
Route::get('admin/{id}/update', 'AdminController@update');
Route::get('admin/{id}/edit', 'AdminController@edit');
Route::get('admin/{user}/update', 'AdminController@show');
Route::resource('admin', 'AdminController');