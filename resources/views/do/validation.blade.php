@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Validation</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">Choix des options de validation</span>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
								
	<!--Begin::Section-->
	@foreach($typeDossiers as $typeDossier)
	<div class="row">
		<div class="col-xl-12">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							{{ $typeDossier->libelle }}
						</h3>
					</div>
				</div>
				<form>
					<div class="card-body">
					<!--begin::Form-->
					<table>
						<tr>
							<td>Intitulé</th>
							<td class="text-center"><input type="text" required class="form-control" onchange="saveTypeDossier({{ $typeDossier->id }}, this.value, 'libelle');" size="16" name="" value="{{ $typeDossier->getField('libelle', $user->societeID) }}" /></td>
						</tr>
						<tr>
							<td>Mécanisme</td>
							<td class="text-center">
								<select name="mecanisme" onchange="saveTypeDossier({{ $typeDossier->id }}, this.value, 'mecanisme_validation');refreshCas(this.value, {{ $typeDossier->id }})" class="form-control">
									<option {{ (($typeDossier->getField('mecanisme_validation', $user->societeID) == 1) ? 'selected' : '') }} value="1">Cas 1</option>
									<option {{ (($typeDossier->getField('mecanisme_validation', $user->societeID) == 2) ? 'selected' : '') }} value="2">Cas 2</option>
									<option {{ (($typeDossier->getField('mecanisme_validation', $user->societeID) == 3) ? 'selected' : '') }} value="3">Cas 3</option>
									<option {{ (($typeDossier->getField('mecanisme_validation', $user->societeID) == 4) ? 'selected' : '') }} value="4"">Cas 4</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Validation Niv 1</td>
								<td class="text-center" id="niv1_{{ $typeDossier->id }}">
									@if($typeDossier->niveau_validation >= 1 && $typeDossier->getField('mecanisme_validation', $user->societeID) > 2)
										<select required name="profil_1" onchange="saveTypeDossier({{ $typeDossier->id }}, this.value, 'profil_1');"  class="form-control">
											<option value="">-- Sélectionnez un profil --</option>
											@foreach($profils as $profil)
												<option {{ (($typeDossier->getField('profil_1', $user->societeID) == $profil->id) ? 'selected' : '') }} value="{{ $profil->id }}">{{ $profil->libelle }}</option>
											@endforeach
										</select>
									@else
										Non requis
									@endif
								</td>
						</tr>
						<tr>
							<td>Validation Niv 2</td>
							<td class="text-center" id="niv2_{{ $typeDossier->id }}">
								@if($typeDossier->niveau_validation > 1 && $typeDossier->getField('mecanisme_validation', $user->societeID) > 2)
									<select required name="profil_2" onchange="saveTypeDossier({{ $typeDossier->id }}, this.value, 'profil_2');"  class="form-control">
										<option value="">-- Sélectionnez un profil --</option>
										@foreach($profils as $profil)
											<option {{ (($typeDossier->getField('profil_2', $user->societeID) == $profil->id) ? 'selected' : '') }} value="{{ $profil->id }}">{{ $profil->libelle }}</option>
										@endforeach
									</select>
								@else
									Non requis
								@endif
							</td>
						</tr>
						<tr>
							<td>Validation Niv 3</td>
							<td class="text-center" id="niv3_{{ $typeDossier->id }}">
								@if($typeDossier->niveau_validation > 2 && $typeDossier->getField('mecanisme_validation', $user->societeID) > 2)
									<select required name="profil_3" onchange="saveTypeDossier({{ $typeDossier->id }}, this.value, 'profil_3');"  class="form-control">
										<option value="">-- Sélectionnez un profil --</option>
										@foreach($profils as $profil)
											<option {{ (($typeDossier->getField('profil_3', $user->societeID) == $profil->id) ? 'selected' : '') }} value="{{ $profil->id }}">{{ $profil->libelle }}</option>
										@endforeach
									</select>
								@else
									Non requis
								@endif
							</td>
						</tr>
						<tr>
							<td><button type="submit" class="btn btn-info">Valider</button></td>
						</tr>
					</table>
				</div>
			</form>
			</div>
		</div>	
	</div>
	@endforeach
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/comptes.js') }}" type="text/javascript"></script>
@endsection