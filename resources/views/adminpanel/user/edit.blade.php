@extends('......layout.main')
@section('content')
@include('adminpanel.user.layout.submenu')
 <article>
	<div id="comprow">
        <div id="register">
            <div class="centerblock">
                <h3>Labot lietotāju: {{$user->username}}</h3>
                {!! Form::model($user, ['method' => 'PATCH' ,'url' => '/adminpanel/user/'.$user->id ,'files' => true , 'enctype' => 'multipart/form-data' ]) !!}
                    {!! Form::label('username' , 'Lietotājvārds') !!}<span class="needed">*</span>
                    {!! Form::text('username', null ,['class' => 'material' ]) !!}
                    {!! Form::label('email' , 'E-pasts') !!}<span class="needed">*</span>
                    {!! Form::email('email', null ,['class' => 'material' ]) !!}
                    {!! Form::label('password' , 'Parole') !!}<span class="needed">*</span>
                    {!! Form::password('password' ,['class' => 'material' ]) !!}
                    {!! Form::label('password_confirmation' , 'Apstipriniet paroli') !!}<span class="needed">*</span>
                    {!! Form::password('password_confirmation' ,['class' => 'material' ]) !!}
                    <div class="one-line small-form">
                    {!! Form::label('status' , 'Lietotāja status') !!}<span class="needed">*</span>
                    {!! Form::select('status', array('1' => 'Lietotājs', '2' => 'Administrātors')) !!}
                    </div>
                    <div class="clear"></div>
                    <div class="one-line small-form">
                        <div id="imagePreview"></div>
                    </div>
                    <div class="one-line medium-form">
                        {!! Form::file('profile_img_link' ,['id'=> 'uploadFile' ,'class'=> 'img']) !!}
                        {!! Form::checkbox('delete_img', '1') !!}
                        <span class="deleteimg">Dzēst pašreizējo attēlu</span>
                    </div>
                    {!! Form::label('facebook' , 'Facebook profila saite') !!}
                    {!! Form::text('facebook', null ,['class' => 'material' ]) !!}
                    {!! Form::submit('Labot' , ['class' => 'submitbtn']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div id="sidebarrow">
    	    @include('adminpanel.user.layout.sidebar')
    	</div>
 </article>
 @stop