@extends('origami::layouts.master')

@section('content')

<div class="section">
	<div class="box">
		<div class="padding">
			<div class="actions">
				@if(count($modules))
				<a href="{{ origami_url('/modules/create') }}" class="button button-action"><svg class="icon"><use xlink:href="#icon-layers"/></use></svg> @lang('origami::global.add')</a>
				@endif
			</div>
			<h1 class="boxtitle">@lang('origami::global.modules') @if(count($modules))<small>{{ count($modules) }}</small>@endif</h1>
			@include('origami::partials.messages')
			@if(count($modules))
			<table class="table clickable sort-modules">
				<thead>
					<tr>
						<th colspan="{{ $modules->count() > 1 ? 2 : 1 }}">@lang('origami::module.name')</th>
						<th class="show-table-l" align="center">@lang('origami::module.fields.title')</th>
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
				<h2 class="t m-b-2">@lang('origami::module.info.get_started')</h2>
				<p class="l w s">@lang('origami::module.info.create')</p>
				<a href="{{ origami_url('/modules/create') }}" class="button button-action">@lang('origami::module.add')</a>
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
