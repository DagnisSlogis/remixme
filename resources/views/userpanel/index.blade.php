@extends('layout.main')
@section('content')
@include('userpanel.layout.UpSubmenu')
<article>
   <div id="full">
    <div class="userinfo">
    <div>
    <img src="{{ asset('/img/check.png') }}">
    <h4>Veiksmīgi izveidoti </h4>
    <span>{{$CompCount}}</span>
    <h4> konkursi</h4>
    </div>
    <div>
    <img src="{{ asset('/img/smile.png') }}">
    <h4>Priecīgi </h4>
    <span>{{$WinnerCount}}</span>
    <h4>uzvarētāji</h4></div>
    <div>
    <img src="{{ asset('/img/comments.png') }}">
    <h4>Interesanti </h4>
    <span>{{$YourComment}}</span>
        <h4>komentāri</h4></div>
    <div>
    <img src="{{ asset('/img/song.png') }}">
    <h4>Lieliski </h4>
    <span>{{$YourSubmitions}}</span>
    <h4>remiksi</h4>
    </div>
    </div>
    </div>
</article>
@stop