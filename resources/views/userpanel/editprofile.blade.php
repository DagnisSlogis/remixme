@extends('layout.main')
@section('content')
@include('userpanel.layout.UpSubmenu')
<article>
	<div id="fullrow">
	<div id="register">
	<div class="centerblock">
		<h3>Labot profilu:</h3>
		@if (Session::has('flash_message'))
                            <div class="alert">{{Session::get('flash_message')}}</div>
                            @endif
		@if (count($errors) > 0)
        	<div class="alert">
        		<strong>Ups!</strong> Jūsu ievadītie dati neatbilst prasītajam formātam.<br>
        			<ul>
        			@foreach ($errors->all() as $error)
        				<li>{{ $error }}</li>
        			@endforeach
        			</ul>
        	</div>
        @endif
		{!! Form::model($user, ['method' => 'PATCH','url' => '/userpanel/profile/update' ,'files' => true , 'enctype' => 'multipart/form-data' ]) !!}
            				{!! Form::label('username' , 'Lietotājvārds') !!}
            				{!! Form::text('username') !!}

                            {!! Form::label('email' , 'E-pasts') !!}
            				{!! Form::email('email') !!}

                            {!! Form::label('password' , 'Jaunā parole') !!}
            				{!! Form::password('password') !!}

            				{!! Form::label('password_confirmation' , 'Apstipriniet paroli') !!}
            				{!! Form::password('password_confirmation') !!}

                            <div class="one-line small-form">
            				<div id="imagePreview" class="float-right"></div>
            				</div>
            				<div class="one-line ">
            				{!! Form::label('profile_img_link' , 'Profila attēls') !!}
            				{!! Form::file('profile_img_link' ,['id'=> 'uploadFile' ,'class'=> 'img']) !!}
            				{!! Form::checkbox('delete_img', '1') !!}
                            {!! Form::label('profile_img_link' , 'Dzēst profila attēlu') !!}
            				</div>

            				<div class="clear"></div>

                            <div class="clear"></div>
            				{!! Form::label('facebook' , 'Facebook profila saite') !!}
            				{!! Form::text('facebook') !!}

            				{!! Form::submit('Labot' , ['class' => 'submitbtn']) !!}
            {!! Form::close() !!}
		</div>
	</div>
	</div>
</article>
@stop