<div id="submenu">
    <ul>
        <li class="title">UZVARĒTĀJI:</li>
        <li>
            {!! Form::open(['url' => '/winners/find', 'method' => 'GET' , 'class' => 'searchform']) !!}
            {!! Form::text('s') !!}
            {!! Form::submit('Meklēt') !!}
            {!! Form::close() !!}
        </li>
    </ul>
</div>