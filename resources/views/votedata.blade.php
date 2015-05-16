<!-- Šajā blade failā tiek attēloti konkursi -->
@foreach ( $comps as $index => $comp)
<div class="RemixComp">
	<img class="comphead" src="{{ asset($comp->header_img) }}">
		<span class="comp-left">{{$comp->comp_end_date->diffForHumans()}}</span>
		<span class="comp-title">{{$comp->title}}</span>
		<span class="comp-end">{{$comp->subm_end_date->format('d.m.Y.')}}</span>
		<div class="votableSongs">
           @foreach($comp->submitions as $place => $subm)
           @if($place == '3')
           @break
           @endif
           <div class="entry">
           <ul>
                <li class="fourFifts"><iframe width="100%" height="60" scrolling="no" frameborder="no"src="http://w.soundcloud.com/player/?url={{$subm->link}}&auto_play=false&color=e45f56&theme_color=00FF00"></iframe></li>
                <li class="oneFift">
                            {!! Form::open (['method' => 'PATCH' ,'url' => 'comp/song/vote/'.$subm->id])!!}
                                {!! Form::submit('Balsot', ['class' => 'delete']) !!}
                            {!! Form::close() !!}
                        </li>
           </ul>
           <ul class="voteInfo">
                    <li><b>Nosaukums:</b> {{$subm->title}}</li>
                    <li><b>Autors:</b> {{$subm->user->username}}</li>
           </ul>
                <div class="place"><span>{{$place+1}}.</span> <p>{{$subm->votes}} balsis</p></div>
           </div>
            @endforeach
		</div>
        <div class="allEntrys"><a href="/comp/voting/{{$comp->id}}">Visi remiksi</a></div>
	</div>
@endforeach