<div class="grid">
	<div class="col-m-12">
		<div class="form-group">
			@include('origami::entries.fieldtypes.partials.label')
			<div class="submodules">
				
				<div class="box">

					{{-- <p class="m-b-3">No items in this list</p>
					<a href="#" class="button button-tiny"><i class="fa fa-plus"></i> Add</a> --}}
					<table class="table clickable sort-entries">
						<thead>
							<tr>
								<th>Title</th>
								<th>Created</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>test 123</td>
								<td>test 123</td>
								<td>test 123</td>
							</tr>
						</tbody>
					</table>
					<button type="submit" name="addEntry" value="{{ $field->uid }}" class="button button-tiny m-t-3"><i class="fa fa-plus"></i> Add</button>
				</div>
			</div>
		</div>
	</div>
</div>