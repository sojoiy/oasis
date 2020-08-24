@extends('layout.default')

@section('content')
@include('livraisons.head', ['active' => 'Documents'])

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<!--Begin::Section-->
	@if($livraison->do <> $user->societeID)
		<div class="row">
			<div class="col-md-12">

				<!--begin:: Widgets/New Users-->
				<div class="card card-custom">
					<div class="card-header">
						<div class="card-title">
							<h3>
								Ajouter des pièces
							</h3>
						</div>
					</div>
					<form class="kt-form" method="POST" action="/livraisons/ajouterdocument" enctype="multipart/form-data">
					<div class="card-body">
						<!--begin::Form-->
						<input type="hidden" name="livraison" value="{{ $livraison->id }}" />
						<input type="hidden" name="societe" value="{{ $user->societeID }}" />
						{{ csrf_field() }}
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Document</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<select id="typePiece" name="type_piece" class="form-control selectpicker">
									@foreach($livraison->pieces_oblig('livraison') as $piece)
										<option value="{{ $piece->id }}">{{ $piece->libelle }}</option>
									@endforeach
								</select>
							</div>
						</div>
				
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Date expiration</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="date" name="date_expiration" value="{{ date('Y-m-d') }}" id="example-date-input">
							</div>
						</div>
				
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Votre fichier</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="file" name="fichier" value="">
							</div>
						</div>
					</div>
					<div class="card-footer d-flex justify-content-between">
						<div class="kt-form__actions">
							<button type="submit" class="btn btn-primary">Valider</button>
							<button type="reset" class="btn btn-secondary">Annuler</button>
						</div>
					</div>
					</form>	
				</div>

				<!--end:: Widgets/New Users-->
			</div>
		</div>
	@endif
	
	<div class="row">
		<div class="col-md-12">
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Les livreurs
						</h3>
					</div>
				</div>
				<div class="card-body">

					<!--begin::Section-->
					<div class="kt-section">
						<div class="kt-section__content">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th class="text-left">Prestataire</th>
											@foreach($livraison->pieces_oblig('livraison') as $piece)
												<th class="text-center" style="width:80px;">{{ $piece->abbreviation }}</th>
											@endforeach
										</tr>
									</thead>
									<tbody id="equipe_livraison">
										@foreach($transporteurs as $prestataire)
											<tr id="ligneEquipier_{{ $prestataire->id }}">
												<td>{{ $prestataire->raisonSociale() }}</td>
												@foreach($livraison->pieces_oblig('livraison') as $piece)
													<td class="text-center" style="width:80px;">
														<i class="far fa-clipboard fa-2x text-{{ $livraison->checkPiece($piece->id, $prestataire->societe) }}"></i></button>
													</td>
												@endforeach
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<!--end::Section-->
				</div>

				<!--end::Form-->
			</div>
		</div>
	</div>	

	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/livraison.js') }}" type="text/javascript"></script>
@endsection