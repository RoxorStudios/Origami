<table class="table clickable sort-entries">
	<thead>
		<tr>
			@if($entries->count() > 1 && $entries->first()->isSortable($entries))
			<th colspan="2">{{ $module->defaultField }}</th>
			@else
			<th>{{ $module->defaultField }}</th>
			@endif
			<th>@lang('origami::global.created')</th>
		</tr>
	</thead>
	<tbody>
		@foreach($entries as $entry)
		<tr data-uid="{{ $entry->uid }}" onclick="window.location.href='{{ origami_url('/entries/'.$entry->module->uid.'/'.$entry->uid) }}'">
			@if($entry->isSortable($entries))
			<td width="25" class="l reorder only-desktop"><i class="fa fa-reorder"></i></td>
			@endif
			<td width="60%">{{ $entry->defaultFieldValue }}</td>
			<td>{{ origami_diff($entry->created_at) }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
