@extends('origami::layouts.auth')

@section('content')

<div class="logo"></div>
@if(!empty($error))
<div class="message message-error">@lang('origami::auth.failed')</div>
@endif
<form method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
		<label>@lang('origami::auth.input.email')</label>
		<input type="text" class="form-input" name="email">
	</div>
	<div class="form-group">
		<label>@lang('origami::auth.input.password')</label>
		<input type="password" class="form-input" name="password">
	</div>
	<div class="checkbox">
		<label>
			<input type="checkbox" name="remember"> @lang('origami::auth.remember_me')
		</label>
	</div>
	<button type="submit" class="button">@lang('origami::auth.login')</button>
	<a class="button button-link">@lang('origami::auth.password_forgot')</a>
</form>

@endsection
