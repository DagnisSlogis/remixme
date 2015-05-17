<header>
	<div class="navblock">
		<ul id="profile-nav">
		@include('layout.profile_nav')
		</ul>
		<h3>remix<i>.me</i></h3>
		<ul id="main-nav"> 
			<li><a href="/"
			@if((Request::is('/'))))
			    class="active"
			@endif
			>Konkursi </a></li>
			<li><a href="/voting"
			@if((Request::is('voting'))))
                class="active"
            @endif
			>Balsošana</a> </li>
			<li><a href="/winners"
			@if((Request::is('winners'))))
                class="active"
            @endif
			>Uzvarētāji</a></li>
		</ul>
		@if(Auth::user())
			<a href="/comps/create"> <button class="add ">+</button></a>
		@endif
		@if (Auth::guest())
            @include('layout.popups.loginPopup')
		@endif
	</div>
</header>