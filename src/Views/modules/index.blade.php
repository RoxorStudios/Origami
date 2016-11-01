@extends('origami::layouts.master')

@section('content')

<div class="section">
	<div class="box">
		<div class="padding">
			<div class="actions">
				@if(count($modules))
				<a href="{{ origami_url('/modules/create') }}" class="button button-action"><svg class="icon"><use xlink:href="#icon-layers"/></use></svg> Add</a>
				@endif
			</div>
			<h1 class="boxtitle">Modules @if(count($modules))<small>{{ count($modules) }}</small>@endif</h1>
			@include('origami::partials.messages')
			@if(count($modules))
			<table class="table clickable sort-modules">
				<thead>
					<tr>
						<th colspan="{{ $modules->count() > 1 ? 2 : 1 }}">Name</th>
						<th class="show-table-l" align="center">Fields</th>
						<th class="show-table-l"></th>
					</tr>
				</thead>

				<tbody>
					@foreach($modules as $module)
					<tr data-uid="{{ $module->uid }}" onclick="window.location.href='{{ origami_url('/modules/'.$module->uid.'/fields') }}'">
						@if($modules->count() > 1)
						<td width="25" class="l reorder only-desktop"><i class="fa fa-reorder"></i></td>
						@endif
						<td>{{ $module->name }}</td>
						<td class="show-table-l" align="center">{{ $module->fields->count() }}</td>
						<td class="show-table-l" align="right">
							<ul class="information">
								@if($module->list)
								<li title="list"><svg class="icon"><use xlink:href="#icon-layers"/></use></svg></li>
								@endif
								@if($module->only_admin)<li title="only admins"><svg class="icon"><use xlink:href="#icon-id-card"/></use></svg></li>@endif
							</ul>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@else
			<div class="no-items">
				<svg class="icon"><use xlink:href="#icon-info"/></use></svg>
				<h2 class="t m-b-2"><b>Let's get started</b> with modules.</h2>
				<p class="l w s">Let's create your first module</p>
				<a href="{{ origami_url('/modules/create') }}" class="button button-action">Add module</a>
			</div>
			@endif
		</div>
	</div>
	
</div>
@endsection

@section('javascript')
	<script>
		app.sortModules();
	</script>
@endsection