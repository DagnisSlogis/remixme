<!-- Šajā blade failā tiek attēloti konkursi -->
@foreach ( $comps as $index => $comp)
<div class="RemixComp">
	<img class="comphead" src="{{ asset($comp->header_img) }}">
		<span class="comp-left">{{$comp->comp_end_date->diffForHumans()}}</span>
		<img class="comp-auth" src="{{ asset($comp->user->profile_img) }}">
		<span class="comp-title">{{$comp->title}}</span>
		<span class="comp-end">{{$comp->created_at->format('d.m.Y.')}}</span>
	<ul class="trackinfo">
	<li><b>Nosaukums:</b> {{$comp->song_title}}</li>
	@if($comp->genre)
	    <li><b>Žanrs:</b> {{$comp->genre}}</li>
	@endif
	@if($comp->bpm)
	<li><b>Temps:</b> {{$comp->bpm}}</li>
	@endif
	@if($comp->voting_type == 'b' )
	<li><b>Vērtēšana:</b> Balsošana</li>
	@else
	<li><b>Vērtēšana:</b> Žūrija</li>
	@endif
	</ul>
	<div class="fullinfo" data-id="{{$comp->id}}">
	@if($comp->preview_type == 's')
   <iframe class="soundcloud" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$comp->preview_link}}&auto_play=false&color=e45f56&theme_color=00FF00"></iframe>
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
	<li><a id="url" href="http://{{$comp->url}}"><img src="{{ asset('/img/social/url.png') }}">{{$comp->url}}</a></li>
	@endif
	@if($comp->twitter)
	<li><a id="twitter" href="http://{{$comp->twitter}}"><img src="{{ asset('/img/social/twitter_small.png') }}">Twitter</a></li>
	@endif
	@if($comp->facebook)
	<li><a id="facebook" href="http://{{$comp->facebook}}"><img src="{{ asset('/img/social/facebook_small.png') }}">Facebook</a></li>
	@endif
	</ul>
	<ul class="functions">
            <a href="/show/{{$comp->id}}" ><li class="other">{{$comp->commentcount()}} Komentāri </li></a>
            <li class="other">Piedalās</li>
            <li>
            {!! Form::open(['method' => 'POST','url' => 'favorite/'.$comp->id]) !!}
            <img src="{{ asset('/img/favorite.png') }}">
            {!! Form::submit('Favorītot' , ['class'=> 'deleteComment']) !!}
            {!! Form::close() !!}
            </li>
	</ul>

	<ul class="functionbtn">
	            <li>
                 {!! Form::open(['method' => 'GET','url' => $comp->stem_link]) !!}
                      {!! Form::submit('Lejupielādēt daļas' , ['class'=> 'downloadbtn']) !!}
                 {!! Form::close() !!}
                 </li>

                <li>
                <button class="subm-window enterbtn" data-id="{{$comp->id}}">Iesniegt</button>

                 </li>
	</ul>
	<div class="clear"></div>
	</div>
	<div class="subminfo" data-id="{{$comp->id}}">
    <h3>Iesniegt dziesmu:</h3>
    {!! Form::open(['method' => 'POST','url' => '/submit/'.$comp->id]) !!}
				{!! Form::label('title' , 'Nosaukums') !!}
				{!! Form::text('title') !!}
				{!! Form::label('link' , 'Soundcload adrese' ) !!}
                {!! Form::text('link' , null , ['class' => 'scLink' , 'data-id' => $comp->id ]) !!}
                <div class="scprev" data-id="{{$comp->id}}"></div>
                <span class="closesubm" data-id="{{$comp->id}}">Aizvērt</span>
           {!! Form::submit('Iesūtit' , ['class'=> 'submitionbtn']) !!}
    {!! Form::close() !!}
	</div>

</div>
@endforeach
@include('layout.popups.subm')