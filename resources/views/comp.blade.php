<!-- Šajā blade failā tiek attēloti konkursi -->
@foreach ( $comps as $index => $comp)
<div class="RemixComp">
	<img class="comphead" src="{{ asset($comp->header_img) }}">
		<span class="comp-left">{{$comp->comp_end_date->diffForHumans()}}</span>
		<img class="comp-auth"src="{{ asset($authors[$index]) }}">
		<span class="comp-title">{{$comp->title}}</span>
		<span class="comp-end">{{$comp->created_at}}</span>
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
@endforeach