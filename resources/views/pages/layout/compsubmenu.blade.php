<div id="submenu">
    <ul>
        <li class="title">BALSOŠANA:</li>
        <li class="compnavl
        @if((Request::is('voting')))
            activesub
        @endif
        "><a href="/voting">Jaunākā</a></li>
        <li class="compnavl
        @if((Request::is('voting/popular')))
            activesub
        @endif
        "><a href="/voting/popular">Populārākā</a></li>
        <li class="compnavl
        @if((Request::is('voting/endsoon')))
            activesub
        @endif
        "><a href="/voting/endsoon">Drīz beigsies</a></li>
        <li>
            {!! Form::open(['url' => '/voting/find', 'method' => 'GET' , 'class' => 'searchform']) !!}
            {!! Form::text('s') !!}
            {!! Form::submit('Meklēt') !!}
            {!! Form::close() !!}
        </li>
    </ul>
</div>