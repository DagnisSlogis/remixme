@extends('layout.main')
@section('content')
@include('pages.layout.submenu')
<article>
	<div id="comprow">
    @include('votedata')
	</div>
	<div id="sidebarrow">
	    @include('layout.sidebar')
	</div>
</article>
@stop