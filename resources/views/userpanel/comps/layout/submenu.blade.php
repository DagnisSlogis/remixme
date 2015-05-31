<div id="submenu">
     <ul>
     	<li class="title">MANI KONKURSI: </li>
     	<li class="compnavl
  	    @if((Request::is('userpanel/comps')))
            activesub
        @endif
     	"><a href="/userpanel/comps">Aktīvie</a></li>
     	<li class="compnavl
   	    @if((Request::is('userpanel/judging')))
            activesub
         @endif
     	"><a href="/userpanel/judging">Vērtēšana
     	@if($judging)
     	    <span class="notif">{{$judging}}</span></a></li>
     	@else
     	    <span class="notif_count">{{$judging}}</span></a></li>
     	@endif
     	<li class="compnavl
   	    @if((Request::is('userpanel/voting')))
            activesub
        @endif
     	"><a href="/userpanel/voting">Balsošana
     	@if($voting)
            <span class="notif">{{$voting}}</span></a></li>
        @else
            <span class="notif_count">{{$voting}}</span></a></li>
        @endif
     	<li class="compnavl
    	@if((Request::is('userpanel/comps/ended')))
            activesub
        @endif
     	"><a href="/userpanel/comps/ended">Beigušies</a></li>
     	<li>
     	    {!! Form::open(['url' => '/comp/user/find', 'method' => 'GET' , 'class' => 'searchform']) !!}
            {!! Form::text('s') !!}
            {!! Form::submit('Meklēt') !!}
            {!! Form::close() !!}
        </li>
     </ul>
</div>