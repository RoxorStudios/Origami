<div class="grid">
	<div class="col-m-12">
		<div class="form-group">
			@include('origami::entries.fieldtypes.partials.label')
			<div class="fileuploader" id="{{ str_random(40) }}" data-module="{{ $module->uid }}" data-name="{{ $field->identifier }}" data-multiple="{{ !empty($field->options['image']['multiple']) ? 1 : 0 }}">
				<div class="selectfile"></div>
				<ul class="uploadedfiles {{ empty($field->options['image']['multiple']) ? 'single' : '' }}">
					@foreach($entry->fetchImagesWithField($field) as $image)
						<li class="active" data-uid="{{ $image['uid'] }}" style="background-image: url({{ origami_content_url($image->path) }})">
							<div class="image_actions">
								<div class="reorder"><i class="fa fa-reorder"></i></div>
								<div class="remove-image"><i class="fa fa-close"></i></div>
							</div>
						</li>
					@endforeach
				</ul>
				<input type="text" name="{{ $field->identifier }}" value="{{ $entry->fetchImageListWithField($field) }}">
			</div>
		</div>
	</div>
</div>

<div class="template action-template">
	<li>
		<div class="image_actions">
			<div class="reorder"><i class="fa fa-reorder"></i></div>
			<div class="remove-image"><i class="fa fa-close"></i></div>
		</div>
	</li>
</div>