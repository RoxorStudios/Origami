@extends('origami::layouts.master')

@section('content')

<div class="banner">
	<div class="content">
		<h1 class="big l t m-0">@lang('origami::dashboard.greeting') {{ $me->firstname }}</h1>
	</div>
</div>

@if($modules->count())
	@foreach($modules as $module)
		@if($module->list)
			<div class="section section-dashboard">
				<div class="box box-dashboard">
					<div class="padding">
						<h1 class="boxtitle m-b-8">{{ $module->name }}</h1>
						@if($module->entries()->count())
							<table class="table clickable sort-entries">
								<thead>
									<tr>
										<th>{{ $module->defaultField }}</th>
										<th>@lang('origami::global.created')</th>
									</tr>
								</thead>
								<tbody>
									@foreach($module->entries as $entry)
										<tr data-uid="{{ $entry->uid }}" onclick="window.location.href='{{ origami_url('/entries/'.$module->uid.'/'.$entry->uid) }}'">
											<td>{{ $entry->defaultFieldValue }}</td>
											<td>{{ origami_diff($entry->created_at) }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@else
						<div class="no-items no-icon">
							<p class="l w s m-0">@lang('origami::module.entries.empty')</p>
						</div>
						@endif

					</div>
				</div>
			</div>
		@endif
	@endforeach
@else
<div class="dashboard">
	<svg class="icon"><use xlink:href="#icon-info"/></use></svg>
	@lang('origami::dashboard.info.module')
</div>
@endif


@endsection
