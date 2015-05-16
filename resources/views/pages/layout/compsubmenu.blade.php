<div id="submenu">
<ul>
	<li class="title">BALSOŠANA:</li>
	<li class="compnavl"><a href="/voting">Jaunākā</a></li>
	<li class="compnavl"><a href="/voting/popular">Populārākā</a></li>
	<li class="compnavl"><a href="/voting/endsoon">Drīz beigsies</a></li>
	     	<li>{!! Form::open(['url' => '/voting/find', 'method' => 'GET' , 'class' => 'searchform']) !!}
                        {!! Form::text('s') !!}
                        {!! Form::submit('Meklēt') !!}
                    {!! Form::close() !!}</li>
</ul>
</div>