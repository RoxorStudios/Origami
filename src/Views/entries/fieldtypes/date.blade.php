<div class="grid">
	<div class="col-m-12">
		<div class="form-group">
			@include('origami::entries.fieldtypes.partials.label')
			
			<input type="text" name="{{ $field->identifier }}" id="datepicker" class="form-input" value="{{ $entry->fetchDataValueWithField($field) }}">
		</div>
	</div>
</div>