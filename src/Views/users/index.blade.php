@extends('origami::layouts.master')

@section('content')

<div class="section">
	<div class="box">
		<div class="padding">
			<div class="actions">
				<a href="{{ origami_url('/users/create') }}" class="button button-action"><svg class="icon"><use xlink:href="#icon-add-admin"/></use></svg> Add</a>
			</div>
			<h1 class="boxtitle">Users<small>{{ count($users) }}</small></h1>
			@include('origami::partials.messages')
			<table class="table clickable">
				<thead>
					<tr>
						<th colspan="2">Name</th>
						<th class="show-table-l">Email</th>
						<th class="show-table-l">Created</th>
						<th class="show-table-l">Lastseen</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						@foreach($users as $user)
						<tr onclick="window.location.href='{{ origami_url('/users/'.$user->uid) }}'">
							<td width="50">
								@if(origami_online($user['lastseen_at']))<div class="status"></div>@endif
								<img src="{{ origami_gravatar($user['email']) }}" width="35" class="circle">
							</td>
							<td><b>{{ $user['firstname'] }}</b> {{ $user['lastname'] }} @if($user['admin'])<span class="label">admin</span>@endif</td>
							<td class="show-table-l">{{ $user['email'] }}</td>
							<td class="show-table-l">{{ origami_diff($user['created_at']) }}</td>
							<td class="show-table-l">{{ origami_diff($user['lastseen_at']) }}</td>
						</tr>
						@endforeach
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
</div>


@endsection