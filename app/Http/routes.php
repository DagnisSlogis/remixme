<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'CompController@index');
Route::get('userpanel' , 'UserPanelController@index');

//Pages
Route::get('adminpanel', 'PageController@AdminPanel');
Route::get('userpanel' ,  'PageController@UserPanel');

//Admin Panel - User
Route::get('adminpanel/users', 'Admin\ApUserController@index');
Route::get('adminpanel/user/{id}/edit', 'Admin\ApUserController@edit');
Route::patch('adminpanel/user/{id}', 'Admin\ApUserController@update');
Route::patch('adminpanel/user/delete/{id}', 'Admin\ApUserController@delete');
Route::get('adminpanel/user/find', 'Admin\ApUserController@find');

//Admin Panel - Competitions
Route::get('adminpanel/comps' , 'Admin\ApCompController@index');
Route::get('adminpanel/comps/accept' ,  'Admin\ApCompController@accept');
Route::patch('adminpanel/comps/accept/{id}' , 'Admin\ApCompController@accept_comp');
Route::patch('adminpanel/comps/delete/{id}', 'Admin\ApCompController@destroy');
Route::post('comment/add/{id}', 'CommentController@add');
Route::post('comment/delete/{id}', 'CommentController@delete');

//Favorite
Route::post('favorite/{id}', 'FavoriteController@add');

Route::resource('comps' , 'CompController');

Route::get('userpanel/profile/edit', 'User\UpProfileController@index');
Route::patch('userpanel/profile/update', 'User\UpProfileController@update');

Route::get('show/{id}', 'CompController@show');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
