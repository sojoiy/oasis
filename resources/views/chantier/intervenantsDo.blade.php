@extends('layout.default')

@section('content')
@include('chantier.head_do', ['active' => 'Intervenants'])

<!-- end:: Content Head -->
@include('chantier.modal_prorogation', ['chantier' => $chantier])

<div class="modal fade" id="kt_modal_newintervenant" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Ajouter un intervenant</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form class="kt-form" id="ajouterIntervenant" method="POST" action="/chantier/addnewintervenantdo">
				<input type="hidden" name="chantier" value="{{ $chantier->id }}" />
				<div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Nom : *</label>
						<input type="text" required name="nom" required class="form-control">
					</div>
					<div class="form-group">
						<label>Prénom :</label>
						<input type="text" name="prenom" class="form-control">
					</div>
					<div class="form-group">
						<label>Fonction :</label>
						<input type="text" name="fonction" class="form-control">
					</div>
					<div class="form-group">
						<label>Société :</label>
						<input type="text" name="societe" class="form-control">
					</div>
					<div class="form-group">
						<label>Email :*</label>
						<input type="text" required name="email" class="form-control">
					</div>
					<div class="form-group">
						<label>Téléphone :</label>
						<input type="text" name="telephone" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Valider</button>
					<button type="reset" class="btn btn-secondary">Annuler</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- begin:: Content -->
<div class="card card-custom">
	<!--Begin::Section-->
	
	
	<div class="row" style="display:none;" id="frm-change">
		
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Intervenants sur le chantier
						</h3>
					</div>

					<div class="kt-portlet__head-toolbar">
						<div class="dropdown dropdown-inline">
							<a class="btn btn-xs" href="#" data-toggle="modal" data-target="#kt_modal_newintervenant" tabindex="-1">
							<i class="fa fa-plus"></i>
							</a>
						</div>
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
											<th class="text-center">#</th>
											<th class="text-center">Nom</th>
											<th class="text-center">Prénom</th>
											<th class="text-center">Société</th>
											<th class="text-center">Fonction</th>
											<th class="text-center">Email</th>
											<th class="text-center">Statut</th>
											@if($user->do)
												<th class="text-center"></th>
											@endif
										</tr>
									</thead>
									<tbody id="equipe_chantier">
										@foreach($equipe as $entite)
											<tr id="ligneEquipier_{{ $entite->id }}">
												<td class="text-center" scope="row" style="width:80px;"></td>
												<td>{{ $entite->nom }}</td>
												<td>{{ $entite->prenom }}</td>
												<td>{{ $entite->societe }}</td>
												<td>{{ $entite->fonction }}</td>
												<td>{{ $entite->email }}</td>
												<td>{{ $entite->statut() }}</td>
												@if($user->do)
													<td class="text-center" id="intervenant_{{ $entite->id }}">
														<button class="btn btn-info btn-sm" onclick="copierUrl({{ $entite->id }})" title="Copier le lien d'accès"><i class="fa fa-link"></i></button>
														<button class="btn btn-info btn-sm" onclick="sendUrl({{ $entite->id }})" title="Copier le lien d'accès"><i class="fa fa-envelope"></i></button>
														<textarea style="display:none;" id="js-copytextarea{{ $entite->id }}" name="url">http://recette.oasis-dev.pro/chantier/accesaction/{{ $entite->url() }}</textarea>
													</td>
												@endif
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
	<script src="{{ asset('assets/js/chantier_do.js') }}" type="text/javascript"></script>
@endsection