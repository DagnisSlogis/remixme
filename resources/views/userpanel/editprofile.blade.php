@extends('layout.main')
@section('content')
<div id="submenu">
<ul>
	<li class="title">PROFILS: </li>
	<li class="compnavl">Mani konkursi</li>
	<li class="compnavl">Favorīti</li>
	<li class="compnavl">Manas Dziesmas</li>
	<li class="compnavl"><a href="userpanel/profile-edit">Labot Profilu</a></li>
</ul>
</div>
<article>
	<div id="fullrow">
	<div id="register">
	<div class="centerblock">
		<h3>Labot profilu:</h3>
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
		{!! Form::model($user, ['method' => 'PATCH','url' => '/userpanel/patch_user' ,'files' => true , 'enctype' => 'multipart/form-data' ]) !!}
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
            				{!! Form::file('profile_img_link') !!}
            				{!! Form::checkbox('delete_img', '1') !!}
                            {!! Form::label('profile_img_link' , 'Dzēst profila attēlu') !!}
            				</div>
            				<div class="clear"></div>

                            <div class="clear"></div>
            				{!! Form::label('facebook' , 'Facebook profila saite') !!}
            				{!! Form::text('facebook') !!}

            				{!! Form::submit('Labot') !!}
            {!! Form::close() !!}
		</div>
	</div>
	</div>
</article>
@stop