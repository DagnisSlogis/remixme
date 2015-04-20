@extends('layout.main')
@section('content')
<div id="submenu">
<ul>
	<li class="title">KONKURSI:</li>
	<li class="compnavl">Jaunākie</li>
	<li class="compnavl">Populārākie</li>
	<li class="compnavl">Drīz beigsies</li>
</ul>
</div>
<article>
	<div id="comprow">
        @include('comp')
	</div>
	<div id="sidebarrow">
	    @include('layout.sidebar')
	</div>
</article>
@stop