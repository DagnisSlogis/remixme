<div id="submenu">
<ul>
	<li class="title">KONKURSU PANELIS:</li>
	<li class="compnavl"><a href="/adminpanel/comps">Notiekošie <span class="notif_count">{{$runningsCount}}</span></a></li>
	@if($unacceptedCount)
	    <li class="compnavl"><a href="/adminpanel/comps/accept">Neapstiprinātie <span class="notif">{{$unacceptedCount}}</span></a></li>
	@else
	    <li class="compnavl"><a href="/adminpanel/comps/accept">Neapstiprinātie</a></li>
	@endif
	<li class="compnavl"><a href="/adminpanel/users">Visi <span class="notif_count">{{$compsCount}}</span></a></li>
	     	<li>{!! Form::open(['url' => '/adminpanel/comps/find', 'method' => 'GET' , 'class' => 'searchform']) !!}
                        {!! Form::text('s') !!}
                        {!! Form::submit('Meklēt') !!}
                    {!! Form::close() !!}</li>

</ul>
</div>