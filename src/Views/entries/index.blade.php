@extends('origami::layouts.master')

@section('content')

<div class="section">
	<div class="box">
		<div class="padding">
			<div class="actions">
				@if($module->list && $module->fields()->count() && $module->entries()->count())
				<a href="{{ origami_url('/entries/'.$module->uid.'/create') }}" class="button button-action"><svg class="icon"><use xlink:href="#icon-layers"/></use></svg> Add</a>
				@endif
			</div>
			<h1 class="boxtitle">{{ $module->name }}</h1>
			@include('origami::partials.messages')
			@if($module->fields()->count())
				@if($module->list)
					@if($entries->count())
						<table class="table clickable sort-entries">
							<thead>
								<tr>
									<th>{{ $module->defaultField }}</th>
									@if($module->list && $entries->count()>1 && $module->sortable)
									<th></th>
									@endif
									<th>Created</th>
								</tr>
							</thead>
							<tbody>
								@foreach($entries as $entry)
								<tr data-uid="{{ $entry->uid }}" onclick="window.location.href='{{ origami_url('/entries/'.$module->uid.'/'.$entry->uid) }}'">
									@if($module->list && $entries->count()>1 && $module->sortable)
									<td width="25" class="l reorder only-desktop"><i class="fa fa-reorder"></i></td>
									@endif
									<td>{{ $entry->defaultFieldValue }}</td>
									<td>{{ origami_diff($entry->created_at) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					@else
						<div class="no-items">
							<svg class="icon"><use xlink:href="#icon-love"/></use></svg>
							<h2 class="t m-b-2"><b>Create</b> the first entry.</h2>
							<p class="l w s">Click the button below to create an item.</p>
							<a href="{{ origami_url('/entries/'.$module->uid.'/create') }}" class="button button-action">Add item</a>
						</div>
					@endif
				@endif
			@else
				@include('origami::entries.partials.no_fields')
			@endif
		</div>
	</div>
</div>

@endsection

@section('javascript')
	<script>
		app.sortEntries('{{ $module->uid }}');
	</script>
@endsection