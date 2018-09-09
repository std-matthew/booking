<!DOCTYPE html>
<html>
<head>
	<title>Booking System</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

	<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

	<div id="app">
		
		@yield('content')

	</div>

	@routes

	<script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>

</body>
</html>