<!-- Šajā blade failā tiek attēloti konkursi -->
@foreach ( $comps as $index => $comp)
<div class="RemixComp">
	<img class="comphead" src="{{ asset($comp->header_img) }}">
		<span class="comp-title">{{$comp->title}}</span>
		<div class="votableSongs">
           @foreach($comp->voting->winners as $winner)
           <div class="entry">
           <ul>
                <li class="fiveFifts"><iframe width="100%" height="100" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$winner->submition->link}}&auto_play=false&color=e45f56&theme_color=00FF00"></iframe></li>
           </ul>
           <ul class="voteInfo">
                    <li><b>Nosaukums:</b> {{$winner->submition->title}}</li>
                    <li><b>Autors:</b> {{$winner->submition->user->username}}</li>
           </ul>
                 <div class="place"><span
                 @if($winner->place == 1)
                 class="first"
                 @endif
                 >{{$winner->place}}.</span> <p>{{$winner->submition->votes}} balsis</p></div>
                           </div>
            @endforeach
		</div>

	</div>
@endforeach