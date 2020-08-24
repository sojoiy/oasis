@foreach($remplacants as $intervenant)
	<option value="{{ $intervenant->id }}" {{ ($intervenant->id == $selected->id) ? 'selected' : '' }}>{{ $intervenant->name }}</option>
@endforeach