@extends('origami::layouts.master')

@section('content')

<div class="section">
	<div class="box">
		<div class="padding">
			<div class="actions">
				@if($module->list)
					@if($entry->parent)
						@if($entry->parent->entry->module->isRootModule())
						<a href="{{ origami_url('/entries/'.$entry->parent->entry->module->uid) }}" class="button button-action button-gray">Cancel</a>
						@else
						<a href="{{ origami_url('/entries/'.$entry->parent->entry->module->uid.'/'.$entry->parent->entry->uid) }}" class="button button-action button-gray">Cancel</a>
						@endif
					@else
					<a href="{{ origami_url('/entries/'.$module->uid) }}" class="button button-action button-gray">Cancel</a>
					@endif
				@endif
			</div>

			<h1 class="boxtitle">
				@if(!empty($parent))
					@if($parent->module->isRootModule())
					<a href="{{ origami_url('/entries/'.$parent->module->uid) }}">{{ $parent->getDefaultFieldValueAttribute() }}</a> >
					@else
					<a href="{{ origami_url('/entries/'.$parent->module->uid.'/'.$parent->uid) }}">{{ $parent->getDefaultFieldValueAttribute() }}</a> >
					@endif
				@endif

				@if($entry->parent)

					@if($entry->parent->entry->module->isRootModule())
					<a href="{{ origami_url('/entries/'.$entry->parent->entry->module->uid) }}">{{ $entry->parent->entry->getDefaultFieldValueAttribute() }}</a> >
					@else
					<a href="{{ origami_url('/entries/'.$entry->parent->entry->module->uid.'/'.$entry->parent->entry->uid) }}">{{ $entry->parent->entry->getDefaultFieldValueAttribute() }}</a> >
					@endif
				@endif

				{{ isset($single) ? $module->name : ($entry->id ? 'Edit entry' : 'New entry') }}
			</h1>
			@if($module->fields()->count())
				<form method="POST" id="editEntry" action="{{ !$entry->uid ? origami_url('/entries/'.$module->uid.'/create') : origami_url('/entries/'.$module->uid.'/'.$entry->uid) }}" enctype='multipart/form-data'>
					@include('origami::partials.errors')
					@include('origami::partials.messages')
					{{ csrf_field() }}

					@foreach($fields as $field)
						@include('origami::entries.fieldtypes.'.$field->type)
					@endforeach

					@if(!empty($parent))
						<input type="hidden" name="parent" value="{{ $parent->uid }}">
					@endif

					<button type="submit" class="button m-t-4">{{ isset($single) ? 'Save' : ($entry->id ? 'Update' : 'Create') }}</button>
					@if($entry->id && $module->list)
						<button type="button" class="button button-link" v-on:click="confirm('Are you absolutely sure you want to remove this entry?','{{ origami_url('/entries/'.$module->uid.'/'.$entry->uid.'/remove') }}')">Remove entry</button>
					@endif
				</form>
			@else
				@include('origami::entries.partials.no_fields')
			@endif
		</div>
	</div>
</div>

@endsection
