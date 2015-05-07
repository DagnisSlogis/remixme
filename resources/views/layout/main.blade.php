<!DOCTYPE html>
<html>
<head>
	<title>Remiksē Mani</title>
	<meta name="_token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="{{ asset('css/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ asset('css/css/style.css') }}">
</head>
    <body>
        @include('layout.header')
        @include('layout.popups.modal')
        @yield('content')
    </body>
</html>
<footer>
	<script src="{{ asset('js/jquery-2.1.3.min.js') }}"></script>
	<script src="{{ asset('js/popup.js') }}"></script>
	<script src="{{ asset('js/notifications.js') }}"></script>
	<script src="{{ asset('js/jquery-ui.js') }}"></script>
	<script>
$(function() {
    $( ".datepicker" ).datepicker()
  });


    </script>
</footer>