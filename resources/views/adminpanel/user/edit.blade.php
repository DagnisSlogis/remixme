@extends('......layout.main')
@section('content')
 <div id="submenu">
 <ul>
 	<li class="title">LABOT LIETOTĀJU: </li>
 	<li class="compnavl"><a href="/adminpanel/changeuser">Labot lietotāju</a></li>
 	<li class="compnavl">Favorīti</li>
 	<li class="compnavl">Manas Dziesmas</li>
 	<li class="compnavl"><a href="/userpanel/profile-edit">Labot Profilu</a></li>
 </ul>
 </div>
 <article>
	<div id="comprow">
	<div id="register">
	<div class="centerblock">
	<h3>Labot lietotāju: {{$user->username}}</h3>
    {!! Form::model($user, ['method' => 'PATCH' ,'url' => '/adminpanel/user/'.$user->id ,'files' => true , 'enctype' => 'multipart/form-data' ]) !!}
    <div class="input-group">
    				{!! Form::text('username', null ,['class' => 'material' ]) !!}
    				{!! Form::label('username' , 'Lietotājvārds') !!}
    				</div>
    				<div class="input-group">
    				{!! Form::email('email', null ,['class' => 'material' ]) !!}
    				{!! Form::label('email' , 'E-pasts') !!}
    				</div>
    				<div class="input-group">
    				{!! Form::password('password' ,['class' => 'material' ]) !!}
    				{!! Form::label('password' , 'Parole') !!}
    				</div>
    				<div class="input-group">
    				{!! Form::password('password_confirmation' ,['class' => 'material' ]) !!}
    				{!! Form::label('password_confirmation' , 'Apstipriniet paroli') !!}
    				</div>
    				{!! Form::select('status', array('1' => 'Lietotājs', '2' => 'Administrātors')) !!}
    				<div class="imgupload">
    				<div id="imagePreview"></div>
    				{!! Form::file('profile_img_link' ,['id'=> 'uploadFile' ,'class'=> 'img']) !!}
    				{!! Form::checkbox('delete_img', '1') !!}
                    <span>Dzēst pašreizējo attēlu</span>
    				</div>
    				<div class="input-group">
    				{!! Form::text('facebook', null ,['class' => 'material' ]) !!}
    				{!! Form::label('facebook' , 'Facebook profila saite') !!}
    				</div>
    				{!! Form::submit('Labot') !!}
    {!! Form::close() !!}
    </div>
    </div>
    </div>
 </article>
 @stop