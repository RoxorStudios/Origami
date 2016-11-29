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
					@if($module->entries()->count())
						@include('origami::entries.partials.entries_table', ['module'=>$module, 'entries'=>$module->entries()->orderBy('position','ASC')->orderBy('id','DESC')->get()])
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