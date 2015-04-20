@extends('layout.main')
@section('content')
<article onload="loadImageFile();">
	<div id="comprow">
	<div id="register">
	<div class="centerblock">
		<h3>Reģistrācija</h3>
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
		{!! Form::open(['name' => 'uploadForm' ,'class' => 'matform' ,'url' => '/auth/register' ,'files' => true , 'enctype' => 'multipart/form-data']) !!}
				{!! Form::label('username' , 'Lietotājvārds') !!}
				{!! Form::text('username') !!}
                {!! Form::label('email' , 'E-pasts') !!}
				{!! Form::email('email') !!}
                {!! Form::label('password' , 'Parole') !!}
				{!! Form::password('password') !!}
				{!! Form::label('password_confirmation' , 'Apstipriniet paroli') !!}
				{!! Form::password('password_confirmation') !!}
                <div class="one-line small-form">
                    <div id="imagePreview"></div>
                </div>
                <div class="one-line medium-form">
				    {!! Form::file('profile_img_link' ,['id'=> 'uploadFile' ,'class'=> 'img']) !!}
                 </div>

				{!! Form::label('facebook' , 'Facebook profila saite') !!}
				{!! Form::text('facebook') !!}

				{!! Form::submit('Reģistrēties') !!}
			{!! Form::close() !!}
		</div>
	</div>
	</div>
	<div id="sidebarrow">
	    @include('layout.sidebar')
	</div>
</article>


@endsection
