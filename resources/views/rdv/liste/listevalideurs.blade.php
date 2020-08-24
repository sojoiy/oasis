<label class="col-lg-2 col-form-label">Choix du valideur niv 2</label>
<div class="col-lg-4">
	<div class="kt-input-icon">
	<select required class="form-control" name="valideur2">
		<option value="0">-- Validation niveau 1 uniquement --</option>
		@foreach($users as $valideur)
			<option value="{{ $valideur->id }}">{{ $valideur->name }}</option>
		@endforeach
	</select>
	</div>
</div>