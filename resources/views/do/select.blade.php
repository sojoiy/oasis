<select required name="profil_1" onchange="saveTypeDossier({{ $typeDossier->id }}, this.value, 'profil_1');"  class="form-control">
	<option value="">-- Sélectionnez un profil --</option>
	@foreach($profils as $profil)
		<option {{ (($typeDossier->getField('profil_1', $user->societeID) == $profil->id) ? 'selected' : '') }} value="{{ $profil->id }}">{{ $profil->libelle }}</option>
	@endforeach
</select>