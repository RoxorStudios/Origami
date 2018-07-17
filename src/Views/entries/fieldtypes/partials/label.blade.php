<label>
	{{ $field->name }}
	@if($field->description)
		<small>{{ $field->description }}</small>
	@endif
	@if($field->required)
		<span class="required">@lang('origami::global.required')</span>
	@endif
</label>
