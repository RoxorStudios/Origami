@extends('origami::layouts.auth')

@section('content')

<div class="logo"></div>
@if(!empty($error))
<div class="message message-error">Authentication failed</div>
@endif
<form method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
		<label>Email</label>
		<input type="text" class="form-input" name="email">
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type="password" class="form-input" name="password">
	</div>
	<div class="checkbox">
		<label>
			<input type="checkbox" name="remember"> Remember me
		</label>
	</div>
	<button type="submit" class="button">Login</button>
	<a class="button button-link">forget pass?</a>
</form>

@endsection