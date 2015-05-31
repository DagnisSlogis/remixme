@extends('layout.main')
@section('content')
<div id="submenu">
    <ul>
        <li class="title">ADMIN PANELIS: </li>
        <li class="compnavl"><a href="adminpanel/users">Lietotāji</a></li>
        <li class="compnavl"><a href="adminpanel/comps">Konkursi</a></li>
    </ul>
</div>
<article>
    <div id="full">
        <div class="userinfo">
            {!! Form::open(['url' => '/adminpanel/find', 'method' => 'GET' , 'class' => 'uniSearch']) !!}
            <h3>Meklē visur</h3>
            {!! Form::text('s') !!}
            {!! Form::select('veids', array('user' => 'Lietotājs', 'comp' => 'Konkurss')) !!}
            {!! Form::submit('Meklēt') !!}
            {!! Form::close() !!}
        </div>
        <div class="userinfo nextline">
            <div>
                <img src="{{ asset('/img/check.png') }}">
                <h4>Kopumā </h4>
                <span>{{$CompCount}}</span>
                <h4> konkursi</h4>
            </div>
            <div>
                <img src="{{ asset('/img/smile.png') }}">
                <h4>Kopā </h4>
                <span>{{$WinnerCount}}</span>
                <h4>uzvarētāji</h4>
            </div>
            <div>
                <img src="{{ asset('/img/comments.png') }}">
                <h4>Publicēti </h4>
                <span>{{$AllComment}}</span>
                <h4>komentāri</h4>
            </div>
            <div>
                <img src="{{ asset('/img/song.png') }}">
                <h4>Iesūtīti </h4>
                <span>{{$AllSubmitions}}</span>
                <h4>remiksi</h4>
            </div>
        </div>
    </div>
</article>
@stop