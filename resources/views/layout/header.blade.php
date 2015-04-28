<header>
	<div class="navblock">
		<ul id="profile-nav">
			@if (Auth::guest())
				<li><a href="#login-box" class="login-window">Pieslēgties / Reģistrētes</a></li>
			@else
				@if ( Auth::user()->isAdmin() )
                    <li><a href="/adminpanel" class="adminbtn">A</a></li>
                @endif
				<li><a href="/userpanel"><img src="{{ asset('/img/profile.png') }}"></a></li>
				<li><img src="{{ asset('/img/heart.png') }}"></li>
				<li class="profile"><a href="/auth/logout">{{Auth::user()->username}}</a><a href="{{Auth::user()->profile_img}}"><img class="profileimg" src="{{ Auth::user()->profile_img}}"></a></li>
			@endif
		</ul>
		<h3>remix<i>.me</i></h3>
		<ul id="main-nav"> 
			<li><a href="/" class="active">Konkursi</a></li>
			<li>Balsošana</li>
			<li>Uzvarētāji</li>
			<li>Par Mums</li>
		</ul>
		@if(Auth::user())
			<a href="/comps/create"> <button class="add ">+</button></a>
		@endif
		@if (Auth::guest())
            @include('layout.popups.loginPopup')
		@endif
	</div>
</header>