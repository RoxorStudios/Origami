@extends('origami::layouts.master')

@section('content')

<div class="section">
	<div class="box">
		<div class="padding">
			<div class="actions">
				<a href="{{ origami_url('/users') }}" class="button button-action button-gray">Cancel</a>
			</div>
			<h1 class="boxtitle">{{ $user->id ? 'Edit user' : 'New user' }}</h1>
			<form method="POST" action="{{ !$user->uid ? origami_url('/users/create') : origami_url('/users/'.$user->uid) }}">
				{{ csrf_field() }}
				@include('origami::partials.errors')
				<div class="grid">
					<div class="col-m-6">
						<div class="form-group">
							<label>Firstname</label>
							<input type="text" name="firstname" v-model="user.firstname" class="form-input" autofocus>
						</div>
					</div>
					<div class="col-m-6">
						<div class="form-group">
							<label>Lastname</label>
							<input type="text" name="lastname" v-model="user.lastname" class="form-input">
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" v-model="user.email" class="form-input">
						</div>
					</div>
					@if(!$user->id)
					<div class="col-12">
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-input">
						</div>
					</div>
					@else
					<div class="col-12">
						<div class="form-group">
							<label>Update password<small>Leave empty to keep the current password</small></label>
							<input type="password" name="update_password" class="form-input">
						</div>
					</div>
					@endif
				</div>
				@if($me->id==$user->id)
					<input type="hidden" name="admin" v-model="user.admin">
				@else
					<input type="hidden" name="admin" value="0">
					<div class="switch-checkbox">
						<label>
							<input type="checkbox" name="admin" v-model="user.admin" v-bind:value="1">
							<div class="title">Admin rights</div>
							<div class="check">
								<div class="handle"></div>
							</div>
						</label>
					</div>
				@endif
				
				<button type="submit" class="button">{{ $user->id ? 'Update' : 'Create' }}</button>
				@if($user->id && $me->id!=$user->id)
					<button type="button" class="button button-link" v-on:click="confirm('Are you absolutely sure you want to remove this user?','{{ origami_url('/users/'.$user->uid.'/remove') }}')">Remove user</button>
				@endif
			</form>
		</div>
	</div>
</div>

@endsection

@section('javascript')
	<script>
		app.user = {
			firstname: '{{ origami_form($user, 'firstname') }}',
			lastname: '{{ origami_form($user, 'lastname') }}',
			email: '{{ origami_form($user, 'email') }}',
			admin: {{ $me->id==$user->id ? 1 : origami_form($user, 'admin') }},
		}
	</script>
@endsection