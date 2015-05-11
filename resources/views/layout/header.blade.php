<header>
	<div class="navblock">
		<ul id="profile-nav">
		@include('layout.profile_nav')
		</ul>
		<h3>remix<i>.me</i></h3>
		<ul id="main-nav"> 
			<li><a href="/" class="active">Konkursi</a></li>
			<li><a href="/voting">Balsošana</a> </li>
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