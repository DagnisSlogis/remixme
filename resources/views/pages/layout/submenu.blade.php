<div id="submenu">
<ul>
	<li class="title">KONKURSI:</li>
	<li class="compnavl
	@if((Request::is('/'))))
        activesub
    @endif
	"><a href="/">Jaunākie</a></li>
	<li class="compnavl
    @if((Request::is('comps/popular'))))
    activesub
    @endif
	"><a href="/comps/popular">Populārākie</a></li>
	<li class="compnavl
	    @if((Request::is('comps/endsoon'))))
        activesub
        @endif
	"><a href="/comps/endsoon">Drīz beigsies</a></li>
	     	<li>{!! Form::open(['url' => '/comps/find', 'method' => 'GET' , 'class' => 'searchform']) !!}
                        {!! Form::text('s') !!}
                        {!! Form::submit('Meklēt') !!}
                    {!! Form::close() !!}</li>
</ul>
</div>