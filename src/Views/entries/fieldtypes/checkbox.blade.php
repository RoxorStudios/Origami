<div class="grid">
	<div class="col-m-12">
		<div class="form-group">
			
			<div class="switch-checkbox">
				<label>
					<input type="checkbox" name="{{ $field->identifier }}" @if($entry->fetchCheckboxStateWithField($field)) checked @endif v-bind:value="1">
					<div class="title">{{ $field->name }}</div>
					<div class="check">
						<div class="handle"></div>
					</div>
				</label>
			</div>

		</div>
	</div>
</div>