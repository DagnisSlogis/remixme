<div id="submenu">
    <ul>
        <li class="title">KONKURSU PANELIS:</li>
        <li class="compnavl
        @if((Request::is('adminpanel/comps')))
            activesub
        @endif
        "><a href="/adminpanel/comps">Notiekošie <span class="notif_count">{{$runningsCount}}</span></a></li>
        @if($unacceptedCount)
        <li class="compnavl
        @if((Request::is('adminpanel/comps/accept')))
            activesub
        @endif
        "><a href="/adminpanel/comps/accept">Neapstiprinātie <span class="notif">{{$unacceptedCount}}</span></a></li>
        @else
        <li class="compnavl
        @if((Request::is('adminpanel/comps/accept')))
            activesub
        @endif
            "><a href="/adminpanel/comps/accept">Neapstiprinātie</a></li>
        @endif
        <li class="compnavl
        @if((Request::is('adminpanel/comps/hasended')))
            activesub
        @endif
        "><a href="/adminpanel/comps/hasended">Beigušies</a></li>
        <li>{!! Form::open(['url' => '/adminpanel/comps/find', 'method' => 'GET' , 'class' => 'searchform']) !!}
            {!! Form::text('s') !!}
            {!! Form::submit('Meklēt') !!}
        {!! Form::close() !!}
        </li>
    </ul>
</div>