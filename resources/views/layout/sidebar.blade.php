<!-- Šajā blade failā tiek attēlots sidebars -->
<span class="sidetitle">Uzzini vienmēr pirmais</span>
<ul id="socialme">
	<li> Seko mums:</li>
	<li class="slinks"><img src="{{ asset('/img/social/twitter.png') }}"></li>
	<li class="slinks"><img src="{{ asset('/img/social/facebook.png') }}"></li>
	<li class="slinks"><img src="{{ asset('/img/social/plus.png') }}"></li>
</ul>
<span class="sidetitle">Jaunākie konkursu uzvarētāji</span>
<!-- Šeit ies funkcija, kas ielasa jaunākos -->
@foreach($winners as $winner)
    <ul class="Latestwinner">
        <li class="latestWin-img"><img src="{{ asset($winner->submition->user->profile_img) }}"></li>
        <li class="latestWin-place">
        @if($winner->place == 1)
            1st
        @elseif($winner->place == 2)
            2nd
        @elseif($winner->place == 3)
            3rd
        @endif
        </li>
        <li class="latestWin-compname">{{$winner->submition->title}}</li>
    </ul>
@endforeach
<a href="/winners"><button class="clasic">Apskatīt visus</button></a>
