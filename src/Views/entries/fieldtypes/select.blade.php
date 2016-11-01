@if(!empty($field->options['select']['options']))
<div class="grid">
	<div class="col-m-12">
		<div class="form-group">
			@include('origami::entries.fieldtypes.partials.label')
			
			@if($field->options['select']['element']=='dropdown')
				<select name="{{ $field->identifier }}">
					@foreach($field->options['select']['options'] as $option)
						<option value="{{ $option['value'] }}" @if($entry->fetchDataValueWithField($field)==$option['value']) selected @endif>{{ $option['name'] }}</option>
					@endforeach
				</select>
			@endif
		</div>

		@if($field->options['select']['element']=='radio')
			
			<div class="radio-buttons">
				@foreach($field->options['select']['options'] as $option)
					<label class="radio-button">
						<input type="radio" name="{{ $field->identifier }}" value="{{ $option['value'] }}" @if($entry->fetchDataValueWithField($field)==$option['value']) checked @endif>{{ $option['name'] }}
					</label>
				@endforeach
			</div>
			
		@endif

	</div>
</div>
@endif