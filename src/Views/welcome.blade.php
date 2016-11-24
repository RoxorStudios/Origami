@extends('origami::layouts.page')

@section('content')


<div class="welcome">
	<div class="middle">
		<div class="logo"><img src="{{ asset('vendor/origami/images/logo.svg') }}"></div>
		<div class="code">php artisan origami:install</div>
	</div>
	<div class="version">v{{ origami_version() }}</div>
</div>

@endsection