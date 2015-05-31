@if (Auth::guest())
	<li class="profilemenu"><a href="#login-box" class="login-window">Pieslēgties / Reģistrētes</a></li>
@else
    <li class="profilemenu profile"><a href="{{Auth::user()->profile_img}}"><img class="profileimg" src="{{ Auth::user()->profile_img}}"></a>{{Auth::user()->username}}</li>
    @if ( Auth::user()->isAdmin() )
        <li class="profilemenu">
        @if($unacceptedComps)
        <a href="/adminpanel/comps/accept" class="adminbtn newnotif">A<span class="unacceptedCount">{{$unacceptedComps}}</span></a></li>
        @else
        <a href="/adminpanel" class="adminbtn">A</a></li>
        @endif
    @endif
    @if($notifCount)
        <li class="profilemenu"><a id="is_read" href="#login-box" class="login-window"><img src="{{ asset('/img/new_notif.png') }}"><span class="notificationCount">{{$notifCount}}</span></a></li>
    @else
        <li class="profilemenu"><a href="/userpanel/notification"><img src="{{ asset('/img/notif.png') }}"></a></li>
    @endif
    <li class="profilemenu"><a href="/userpanel"><img src="{{ asset('/img/profile.png') }}"></a></li>
    <li class="profilemenu"><a href="/userpanel/favorite"><img src="{{ asset('/img/heart.png') }}"></a></li>
    <li class="profilemenu"><a href="/auth/logout"><img src="{{ asset('/img/logout.png') }}"></a></li>
    @include('layout.popups.notification')
@endif