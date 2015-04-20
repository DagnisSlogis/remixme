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

Route::get('/', 'HomeController@index');
Route::get('userpanel' , 'UserPanelController@index');

Route::get('adminpanel', 'AdminController@index');
Route::get('adminpanel/changeuser', 'AdminController@change_user');
Route::get('adminpanel/{id}/edit', 'AdminController@edit');
Route::patch('adminpanel/{id}', 'AdminController@update');
Route::patch('adminpanel/delete/{id}', 'AdminController@delete');
Route::get('adminpanel/find', 'AdminController@find');

Route::get('userpanel/profile-edit', 'UserPanelController@edit_profile');
Route::patch('userpanel/patch_user', 'UserPanelController@patch_user');

Route::resource('comps' , 'CompController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
