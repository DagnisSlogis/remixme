@extends('layout.main')
@section('content')
<article >
	<div id="comprow">
	<div id="register">
	<div class="centerblock">
		<h3>Pieslēgties</h3>
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
		{!! Form::open(['url' => '/auth/login', 'method' => 'POST' ]) !!}
		        {!! Form::hidden( csrf_token() , '_token') !!}
                {!! Form::label('email' , 'E-pasts') !!}
				{!! Form::email('email' , old('email')) !!}
                {!! Form::label('password' , 'Parole') !!}
				{!! Form::password('password') !!}
					<div class="one-line small-form">
                		{!! Form::checkbox('remember') !!}
                		</div>
                		<div class="one-line medium-form">
                		{!! Form::label('remember' , 'Atcerēties mani' ) !!}
                        </div>
                        <div class="clear"></div>
				{!! Form::submit('Pieslēgties') !!}
			{!! Form::close() !!}
		</div>
	</div>
	</div>
	<div id="sidebarrow">
	    @include('layout.sidebar')
	</div>
</article>
@endsection
