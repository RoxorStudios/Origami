@extends('origami::layouts.master')

@section('content')

<div class="section">
	<div class="box">
		<div class="padding">
			<div class="actions">
				<a href="{{ origami_url('/modules/'.$module->uid) }}" class="button button-action button-action-gray">@lang('origami::global.edit')</a>
				@if($module->fields->count())
				<a href="{{ origami_url('/modules/'.$module->uid.'/fields/create') }}" class="button button-action"><svg class="icon"><use xlink:href="#icon-layers"/></use></svg> @lang('origami::global.add')</a>
				@endif
			</div>
			<h1 class="boxtitle">

				@foreach(getSubmoduleTree($module) as $submodule)
					<a href="{{ origami_url('/modules/'.$submodule->uid.'/fields') }}">{{ $submodule->name }}</a> <span class="light"><i class="fa fa-angle-right"></i></span>
				@endforeach

				{{ !$module->field ? $module->name : $module->field->name }}

			</h1>
			@include('origami::partials.messages')

			@if($module->fields->count())
				<div class="fields">
					@foreach($fields as $field)
						<div class="field" data-uid="{{ $field->uid }}"
						onclick="window.location.href='{{ $field->submodule ? origami_url('/modules/'.$field->submodule->uid.'/fields/') : origami_url('/modules/'.$module->uid.'/fields/'.$field->uid) }}'">
							<div class="reorder"><i class="fa fa-reorder"></i></div>
							<svg class="icon"><use xlink:href="#icon-fieldtype-{{ $field->type }}"/></use></svg>
							<h5 class="m-b-0">
								{{ $field->name }}
								@if($field->default)<small>@lang('origami::global.default')</small>@endif
							</h5>
						</div>
					@endforeach
				</div>
			@else
			<div class="no-items">
				<svg class="icon"><use xlink:href="#icon-info"/></use></svg>
				<h2 class="t m-b-2">@lang('origami::module.fields.empty')</h2>
				<p class="l w s">@lang('origami::module.fields.empty_message')</p>
				<a href="{{ origami_url('/modules/'.$module->uid.'/fields/create') }}" class="button button-action">@lang('origami::field.add')</a>
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
