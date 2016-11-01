<div class="radiobutton-icon">
	<input class="radio" type="radio" name="type" v-model="field.type"  value="{{ $type }}" id="type_{{ $type }}">
	<label for="type_{{ $type }}">
		<svg class="icon"><use xlink:href="#icon-fieldtype-{{ $type }}"/></use></svg>
		<p>{{ $type }}</p>
	</label>
</div>