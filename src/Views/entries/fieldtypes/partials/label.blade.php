<label>
	{{ $field->name }}
	@if($field->description)
		<small>{{ $field->description }}</small>
	@endif
	@if($field->required)
		<span class="required">Required</span>
	@endif
</label>