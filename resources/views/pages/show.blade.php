@extends('layout.main')
@section('content')
@include('pages.layout.submenu')
<article>
<div class="RemixComp">
	<img class="comphead" src="{{ asset($comp->header_img) }}">
		<span class="comp-left">{{$comp->comp_end_date->diffForHumans()}}</span>
		<img class="comp-auth"src="{{ asset($comp->user->profile_img)}}">
		<span class="comp-title">{{$comp->title}}</span>
		<span class="comp-end">{{$comp->created_at->format('d.m.Y.')}}</span>
	<ul class="trackinfo">
	<li><b>Nosaukums:</b> {{$comp->song_title}}</li>
	<li><b>Žanrs:</b> {{$comp->genre}}</li>
	<li><b>Temps:</b> {{$comp->bpm}}</li>
	<li><b>Vērtēšana:</b> {{$comp->voting_type}}</li>
	</ul>
	@if($comp->preview_type == 's')
   <iframe class="soundcloud" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$comp->preview_link}}&auto_play=false&color=915f33&theme_color=00FF00"></iframe>
   @else
   <iframe class="youtube" src="{{$comp->preview_link}}?autoplay=0&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>
   @endif
   <p>
	<b>Apraksts: </b> {{$comp->description}} </p>
	<p>
	<b>Balvas: </b> {{$comp->prizes}}</p>
	<p>
	<b>Noteikumi: </b> {{$comp->rules}}</p>
</div>
<div class="commentInput">
{!! Form::open(['method' => 'POST','url' => '/comment/add/'.$comp->id]) !!}
		{!! Form::label('text' , 'Teksts') !!} <span class="needed">*</span>
		{!! Form::textarea('text') !!}
		<div class="addcomment">
		<span class="commentInfo">Kā: {{Auth::user()->username}}</span>
        {!! Form::submit('Komentēt' , ['class'=> 'btnadd commentbtn']) !!}
        </div>
{!! Form::close() !!}
</div>
<div class="commentBox">
    @foreach($comments as $comment)
    <div class="comment
        @if(Session::get('new_comment') == $comment->id)
        new
        @endif">
        <img src="{{ asset($comment->user->profile_img)}}">
        <div class="metaData">
        <h4>{{$comment->user->username}}</h4>
        <span>{{$comment->created_at->diffForHumans()}}</span>
        @if(Auth::user()->id == $comment->user->id)
        {!! Form::open(['method' => 'POST','url' => '/comment/delete/'.$comment->id]) !!}
        {!! Form::submit('x' , ['class'=> 'deleteComment']) !!}
        {!! Form::close() !!}
        @endif
        </div>
        <p>{{$comment->text}}</p>
    </div>

    @endforeach

  {!! $comments->appends(Request::except('page'))->render() !!}
</div>
</article>
@stop