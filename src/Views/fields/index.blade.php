@extends('origami::layouts.master')

@section('content')

<div class="section">
	<div class="box">
		<div class="padding">
			<div class="actions">
				<a href="{{ origami_url('/modules/'.$module->uid) }}" class="button button-action button-action-gray">Edit</a>
				@if($module->fields->count())
				<a href="{{ origami_url('/modules/'.$module->uid.'/fields/create') }}" class="button button-action"><svg class="icon"><use xlink:href="#icon-layers"/></use></svg> Add</a>
				@endif
			</div>
			<h1 class="boxtitle">
				@if($module->field)
				<a href="{{ origami_url('/modules/'.$module->field->module->uid.'/fields') }}">{{ $module->field->module->name }}</a> <span class="light"><i class="fa fa-angle-right"></i></span> 
				@endif
				{{ !$module->field ? $module->name : $module->field->name }} 
				@if($module->field)
				<small>Submodule</small>
				@endif


			</h1>
			@include('origami::partials.messages')
			
			@if($module->fields->count())
				<div class="fields">
					@foreach($fields as $field)
						<div class="field" data-uid="{{ $field->uid }}" onclick="window.location.href='{{ origami_url('/modules/'.$module->uid.'/fields/'.$field->uid) }}'">
							<div class="reorder"><i class="fa fa-reorder"></i></div>
							<svg class="icon"><use xlink:href="#icon-fieldtype-{{ $field->type }}"/></use></svg>
							<h5 class="m-b-0">
								{{ $field->name }}
								@if($field->default)<small>Default</small>@endif
							</h5>
						</div>
					@endforeach
				</div>
			@else
			<div class="no-items">
				<svg class="icon"><use xlink:href="#icon-info"/></use></svg>
				<h2 class="t m-b-2"><b>This module</b> doens't have any fields.</h2>
				<p class="l w s">Let's create one to get started</p>
				<a href="{{ origami_url('/modules/'.$module->uid.'/fields/create') }}" class="button button-action">Add field</a>
			</div>
			@endif
			
		</div>
	</div>
	
</div>
@endsection

@section('javascript')
	<script>
		app.sortFields('{{ $module->uid }}');
	</script>
@endsection