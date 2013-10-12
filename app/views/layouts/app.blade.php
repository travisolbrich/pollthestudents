@extends('layouts.master')

@section('pageContent')
<div class="container">

	@include('includes.masthead')
	
	@yield('content')
	
	<div class="footer">
		<p>TAMU Google Hackathon October 2013</p>
	    <p>Travis Olbrich, Derek Burgman, Luis Flores</p>
	</div>
</div>

@yield('javascripts')