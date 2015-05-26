@extends('layout.main')
@section('content')
@include('pages.layout.submenu')
<article>
<div class="RemixComp">
	<img class="comphead" src="{{ asset($comp->header_img) }}">
	    @if($comp->voting->status == 'b')
            <span class="comp-left">Beidzies</span>
        @else
            <span class="comp-left">{{$comp->subm_end_date->diffForHumans()}}</span>
        @endif
		<img class="comp-auth"src="{{ asset($comp->user->profile_img)}}">
		<span class="comp-title">{{$comp->title}}</span>
		<span class="comp-end">{{$comp->created_at->format('d.m.Y.')}}</span>
	<ul class="trackinfo">
	<li><b>Nosaukums:</b> {{$comp->song_title}}</li>
	<li><b>Žanrs:</b> {{$comp->genre}}</li>
	<li><b>Temps:</b> {{$comp->bpm}}</li>
	<li><b>Vērtēšana:</b>
	@if($comp->voting_type == 'z')
        Žūrija
	@else
	    Balsošana
	@endif
	</li>
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
	<ul class="moreinfo">
    	<li id="moreinfo_title">VAIRĀK:</li>
    	@if($comp->url)
    	<li><a class="url" href="http://{{$comp->url}}"><img src="{{ asset('/img/social/url.png') }}">{{$comp->url}}</a></li>
    	@endif
    	@if($comp->twitter)
    	<li><a class="twitter" href="http://{{$comp->twitter}}"><img src="{{ asset('/img/social/twitter_small.png') }}">Twitter</a></li>
    	@endif
    	@if($comp->facebook)
    	<li><a class="facebook" href="http://{{$comp->facebook}}"><img src="{{ asset('/img/social/facebook_small.png') }}">Facebook</a></li>
    	@endif
    	</ul>
    	@if($comp->voting->status == 'v')
    	<ul class="functions">
                <a href="/show/{{$comp->id}}" ><li class="other">{{$comp->commentcount()}} Komentāri </li></a>
                <li class="other">{{$comp->entrycount()}} Piedalās</li>
                <li>
                {!! Form::open(['method' => 'POST','url' => 'favorite/'.$comp->id]) !!}
                <img src="{{ asset('/img/favorite.png') }}">
                {!! Form::submit('Favorītot' , ['class'=> 'deleteComment']) !!}
                {!! Form::close() !!}
                </li>
    	</ul>

    	<ul class="functionbtnfull">
    	            <li>
                     {!! Form::open(['method' => 'GET','url' => $comp->stem_link]) !!}
                          {!! Form::submit('Lejupielādēt daļas' , ['class'=> 'downloadbtn']) !!}
                     {!! Form::close() !!}
                     </li>

                    <li>
                    <button class="subm-window enterbtn" data-id="{{$comp->id}}">Iesniegt</button>

                     </li>
    	</ul>
    	@endif
    	@if($comp->voting->status == 'b')
        <div class="winners">
        <h3>Uzvarētāji</h3>
        <div class="winnerblock">
        @foreach($comp->voting->winners as $winner)
        <div class="innerblock">
            @if($winner->place == '1')
                <a href="{{$winner->submition->link}}"><div class="firstplace">
                    <span>{{$winner->place}}. vieta</span>
                    <img src="{{ asset($winner->submition->user->profile_img) }}">
                    {{$winner->submition->user->username}}
                </div></a>
            @else
                 <a href="{{$winner->submition->link}}"><div class="otherplace">
                    <span>{{$winner->place}}. vieta</span>
                    <img src="{{ asset($winner->submition->user->profile_img) }}">
                    {{$winner->submition->user->username}}
                </div></a>
            @endif
            </div>
        @endforeach
        </div>
        </div>
        @endif
        <div class="clear"></div>
</div>
@if(!Auth::guest())
<div class="commentInput">
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
<h3>Komentāri:</h3>
{!! Form::open(['method' => 'POST','url' => '/comment/add/'.$comp->id]) !!}
		{!! Form::label('text' , 'Teksts') !!} <span class="needed">*</span>
		{!! Form::textarea('text') !!}
		<div class="addcomment">
		<span class="commentInfo">Kā: {{Auth::user()->username}}</span>
        {!! Form::submit('Komentēt' , ['class'=> 'btnadd commentbtn']) !!}
        </div>
{!! Form::close() !!}
</div>
@endif
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
        @if(!Auth::guest())
            @if(Auth::user()->id == $comment->user->id || Auth::user()->isAdmin())
            {!! Form::open(['method' => 'POST','url' => '/comment/delete/'.$comment->id]) !!}
            {!! Form::submit('x' , ['class'=> 'deleteComment']) !!}
            {!! Form::close() !!}
            @endif
        @endif
        </div>
        <p>{{$comment->text}}</p>
    </div>

    @endforeach

  {!! $comments->appends(Request::except('page'))->render() !!}
</div>
</article>
@stop