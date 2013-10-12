@extends('layouts.master')

@section('pageContent')
<div class="container">

	@include('includes.masthead')
	
	@yield('content')
	<hr>
	@include('includes.footer')
</div>
@stop
