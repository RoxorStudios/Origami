<div class="grid">
	<div class="col-m-12">
		<div class="form-group">
			@include('origami::entries.fieldtypes.partials.label')
			<textarea class="form-textarea" @if(isset($field->options['textarea']['markdown'])) id="markdown" @endif name="{{ $field->identifier }}" rows="5" name="{{ $field->uid }}">{{ $entry->fetchDataValueWithField($field) }}</textarea>
		</div>
	</div>
</div>