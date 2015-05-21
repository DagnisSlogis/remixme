<div id="login-box" class="login-popup">
	<a href="#" class="close">x</a>
	<h2>Pieslēgties</h2>
	<div class="boxbody">
		{!! Form::open(['class' => 'loginbox' , 'url' => 'auth/login']) !!}

		{!! Form::label('email' , 'E-pasts') !!}
		{!! Form::text('email') !!}

		{!! Form::label('password' , 'Parole') !!}
		{!! Form::password('password') !!}
		<div class="one-line small-form">
		{!! Form::checkbox('remember') !!}
		</div>
		<div class="one-line medium-form">
		{!! Form::label('remember' , 'Atcerēties mani' ) !!}
        </div>
        <div class="clear"></div>
		{!! Form::submit('Pieslegties', ['class'=> 'btnadd centerbtn']) !!}
		{!! Form::close() !!}
		<p> Nav konta : <a href="/auth/register">Reģistrējies</a></p>

	</div>
</div>