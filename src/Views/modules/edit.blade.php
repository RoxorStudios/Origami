@extends('origami::layouts.master')

@section('content')

<div class="section">
	<div class="box">
		<div class="padding">
			<div class="actions">
				<a href="{{ $module->id ? origami_url('/modules/'.$module->uid.'/fields') : origami_url('/modules') }}" class="button button-action button-gray">@lang('origami::global.cancel')</a>
			</div>
			<h1 class="boxtitle">{{ $module->id ? trans('origami::module.edit') : trans('origami::module.new') }}</h1>
			<form method="POST" action="{{ !$module->uid ? origami_url('/modules/create') : origami_url('/modules/'.$module->uid) }}">
				{{ csrf_field() }}
				@include('origami::partials.errors')

				<div class="m-b-3">
					<div class="radiobutton-icon">
						<input class="radio" v-model="module.list" type="radio" name="list" value="0" id="list-0">
						<label for="list-0">
							<svg class="icon"><use xlink:href="#icon-single"/></use></svg>
							<p>@lang('origami::module.single')</p>
						</label>
					</div>
					<div class="radiobutton-icon">
						<input class="radio" v-model="module.list" type="radio" name="list" value="1" id="list-1">
						<label for="list-1">
							<svg class="icon"><use xlink:href="#icon-list"/></use></svg>
							<p>@lang('origami::module.list.title')</p>
						</label>
					</div>
				</div>

				<div class="grid">
					<div class="col-m-12">
						<div class="form-group">
							<label>@lang('origami::global.name')</label>
							<input type="text" v-model="module.name" name="name" class="form-input" autofocus>
						</div>
					</div>
				</div>

				<div class="checkboxes">
					<input type="hidden" name="sortable" value="0">
					<div class="switch-checkbox" v-if="module.list==1">
						<label>
							<input type="checkbox" name="sortable" v-model="module.sortable" v-bind:value="1">
							<div class="title">@lang('origami::global.sortable')</div>
							<div class="check">
								<div class="handle"></div>
							</div>
						</label>
					</div>

					<input type="hidden" name="only_admin" value="0">
					<div class="switch-checkbox">
						<label>
							<input type="checkbox" name="only_admin" v-model="module.only_admin" v-bind:value="1">
							<div class="title">@lang('origami::module.info.admin')</div>
							<div class="check">
								<div class="handle"></div>
							</div>
						</label>
					</div>

					<input type="hidden" name="dashboard" value="0">
					<div class="switch-checkbox" v-if="module.list==1">
						<label>
							<input type="checkbox" name="dashboard" v-model="module.dashboard" v-bind:value="1">
							<div class="title">@lang('origami::module.info.dashboard')</div>
							<div class="check">
								<div class="handle"></div>
							</div>
						</label>
					</div>
				</div>

				<button type="submit" class="button">{{ $module->id ? trans('origami::global.update') : trans('origami::global.create') }}</button>
				@if($module->id)
				<button type="button" class="button button-link" v-on:click="confirm('{{ trans('origami::module.info.remove') }}','{{ origami_url('/modules/'.$module->uid.'/remove') }}')">@lang('origami::module.remove')</button>
				@endif
			</form>
		</div>
	</div>
</div>
@endsection

@section('javascript')
	<script>
		app.module = {
			name: '{{ origami_form($module, 'name') }}',
			list: {{ origami_form($module, 'list') ?: 0 }},
			sortable: {{ origami_form($module, 'sortable') ?: 0 }},
			only_admin: {{ origami_form($module, 'only_admin') ?: 0 }},
			dashboard: {{ origami_form($module, 'dashboard') ?: 0 }},
		}
	</script>
@endsection
