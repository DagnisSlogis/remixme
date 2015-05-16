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

Blade::extend(function($value)
{
    return preg_replace('/(\s*)@(break|continue)(\s*)/', '$1<?php $2; ?>$3', $value);
});

Route::get('/', 'CompController@index');

//Submitions
Route::post('submit/{id}' , 'SubmitionController@store');

//Pages
Route::get('adminpanel', 'PageController@AdminPanel');
Route::get('userpanel' ,  'PageController@UserPanel');
Route::get('winners' , 'PageController@WinnerPage');

//Admin Panel - User
Route::get('adminpanel/users', 'Admin\ApUserController@index');
Route::get('adminpanel/user/{id}/edit', 'Admin\ApUserController@edit');
Route::patch('adminpanel/user/{id}', 'Admin\ApUserController@update');
Route::patch('adminpanel/user/delete/{id}', 'Admin\ApUserController@delete');
Route::get('adminpanel/user/find', 'Admin\ApUserController@find');

//Admin Panel - Competitions
Route::get('adminpanel/comps' , 'Admin\ApCompController@index');
Route::get('adminpanel/comps/find' , 'Admin\ApCompController@find');
Route::get('adminpanel/comps/accept' ,  'Admin\ApCompController@accept');
Route::patch('adminpanel/comps/accept/{id}' , 'Admin\ApCompController@accept_comp');


//Favorite
Route::post('favorite/{id}', 'FavoriteController@add');

//Notifications
Route::post('is_read' , 'NotificationController@set_as_read');


Route::get('comps/find' , 'CompController@find');
Route::get('comps/endsoon' , 'CompController@soonEnds');
Route::get('comps/popular' , 'CompController@popular');
Route::get('comps/create', 'CompController@create');
Route::post('comps/store' , 'CompController@store');
Route::patch('comps/delete/{id}', 'CompController@destroy');
Route::post('comment/add/{id}', 'CommentController@add');
Route::post('comment/delete/{id}', 'CommentController@delete');

//UserPanel
Route::get('userpanel' , 'PageController@UserPanel');
Route::get('userpanel/profile/edit', 'User\UpProfileController@index');
Route::patch('userpanel/profile/update', 'User\UpProfileController@update');
Route::get('userpanel/notification' , 'NotificationController@index');
Route::get('userpanel/favorite' , 'FavoriteController@index');
Route::patch('userpanel/favorite/delete/{id}', 'FavoriteController@delete');
Route::get('comp/submitions/{id}' , 'SubmitionController@compSubmitions');
Route::patch('comp/song/delete/{id}' , 'SubmitionController@delete');
Route::get('userpanel/mysongs' , 'SubmitionController@index');



//Userpanel
Route::get('userpanel/comps' ,  'User\UpCompController@index');
Route::get('userpanel/comps/ended' ,  'User\UpCompController@hasEnded');
Route::get('comp/{id}/edit' , 'CompController@edit');
Route::patch('comp/{id}' , 'CompController@update');
Route::get('comp/user/find', 'User\UpCompController@find');
Route::get('userpanel/judging' , 'User\UpVotingController@index');
Route::get('comp/judge/{id}' , 'User\UpVotingController@judging');
Route::patch('comp/judge/update/{id}' , 'User\UpVotingController@update');
Route::get('userpanel/voting' , 'User\UpVotingController@voting');
Route::get('comp/voting/accept/{id}' , 'User\UpVotingController@acceptVoting');

Route::get('show/{id}', 'CompController@show');

//Voting
Route::get('voting' , 'VotingController@index');
Route::get('voting/endsoon' , 'VotingController@soonEnds');
Route::get('voting/popular' , 'VotingController@popular');
Route::get('voting/find' , 'VotingController@find');
Route::patch('comp/song/vote/{id}' , 'VotingController@update');
Route::get('comp/voting/{id}' , 'VotingController@show');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
