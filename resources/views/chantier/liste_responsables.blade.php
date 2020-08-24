<label>Responsable : *</label>
<select name="valideur" class="form-control selectpicker">
	@foreach($valideurs as $valideur)
		<option value="{{ $valideur->id }}">{{ $valideur->name }}</option>
	@endforeach
</select>