@extends('layout.main')
@section('content')
@include('pages.layout.winnersubmenu')
<article>
	<div id="comprow">
    @include('winnerdata')
	</div>
	<div id="sidebarrow">
	    @include('layout.sidebar')
	</div>
</article>
@stop