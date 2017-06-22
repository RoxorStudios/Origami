<div class="grid">
	<div class="col-m-12">
		<div class="form-group">
			@include('origami::entries.fieldtypes.partials.label')
			<div class="submodules">
				<div class="box">

					@if(!$entries = $entry->submoduleEntries($field))
					<p class="m-b-3">No items in this list</p>
					@else
					@include('origami::entries.partials.entries_table',['module'=>$module,'entries'=>$entries])
					@endif

					<button type="button" v-on:click="addEntryToSubmodule('{{ $field->uid }}')" class="button button-tiny m-t-3"><i class="fa fa-plus"></i> Add</button>
				</div>
			</div>
		</div>
	</div>
</div>
<input name="addEntry" type="hidden">

@section('javascript')
	<script>
		app.sortEntries('{{ $module->uid }}');
	</script>
@endsection
