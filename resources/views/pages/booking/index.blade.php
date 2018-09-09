@extends('master')

@section('content')

<div class="container">

	<booking
		:fetchlocationurl="'{{ route('fetch.locations') }}'"
	></booking>
		
</div>

@endsection