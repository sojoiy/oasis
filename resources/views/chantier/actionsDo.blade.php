@extends('layout.default')

@section('content')
@include('chantier.head_do', ['active' => 'Actions'])

<!-- end:: Content Head -->
@include('chantier.modal_prorogation', ['chantier' => $chantier])

<div class="modal fade" id="kt_modal_newaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Créer une action</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form class="kt-form" id="ajouterAction" method="POST" action="/chantier/addnewaction">
				<input type="hidden" name="chantier" value="{{ $chantier->id }}" />
				<div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Libellé : *</label>
						<input type="text" name="libelle" required class="form-control" placeholder="Nom">
					</div>
					<div class="form-group">
						<label>Ordre :</label>
						<input type="text" name="ordre" class="form-control" placeholder="Ordre">
					</div>
					<div class="form-group">
						<label>Enchainement :</label>
						<select name="mode" class="form-control">
							<option value="synchrone">Synchrone</option>
							<option value="asynchrone">Asynchrone</option>
						</select>
					</div>
					<div class="form-group">
						<label>Qui :</label>
						<select name="intervenant" class="form-control">
							@foreach($intervenants as $intervenant)
								<option value="{{ $intervenant->id }}">{{ $intervenant->nom }}</option>
							@endforeach
						</select>
						
					</div>
					<div class="form-group">
						<label>Date limite :</label>
						<input class="form-control" type="date" name="date_limite" value="" id="example-date-input">
					</div>
					<div class="form-group">
						<label>Nécessite une validation :</label>
						<div>
							<span class="kt-switch">
								<label>
									<input type="checkbox" name="need_validation" />
									<span></span>
								</label>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label>De la prt de qui :</label>
						<select name="validation" class="form-control">
							<option value="0"></option>
							@foreach($intervenants as $intervenant)
								<option value="{{ $intervenant->id }}">{{ $intervenant->nom }}</option>
							@endforeach
						</select>
						
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
	<div class="row">
		<div class="col-md-12">
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Actions
						</h3>
					</div>

					<div class="kt-portlet__head-toolbar">
						<div class="dropdown dropdown-inline">
							<button class="btn btn-xs text-success" onclick="demarrer({{ $chantier->id }})">
								<i class="fa fa-play"></i>
							</button>
							
							<a class="btn btn-xs" href="#" data-toggle="modal" data-target="#kt_modal_newaction" tabindex="-1">
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
											<th class="text-center">Nom</th>
											<th class="text-center">Qui</th>
											<th class="text-center">Limite</th>
											<th class="text-center">Validation</th>
											<th class="text-center">Documents</th>
											<th class="text-center"></th>
										</tr>
									</thead>
									<tbody id="listeAction">
										@foreach($actions as $action)
											<tr id="action_{{ $action->id }}">
												<td class="text-center {{ ($action->statut == 'en cours') ? 'text-success' : ''}}" nowrap>{{ $action->libelle }}</td>
												<td class="text-center {{ ($action->statut == 'en cours') ? 'text-success' : ''}}" nowrap>{{ $action->nomQui() }}</td>
												<td class="text-center {{ ($action->statut == 'en cours') ? 'text-success' : ''}}" nowrap>{{ date("d/m/Y", strtotime($action->date_limite)) }}</td>
												<td class="text-center {{ ($action->statut == 'en cours') ? 'text-success' : ''}}" nowrap>{{ ($action->validation == 0) ? 'Non requise' : $action->info_validation() }}</td>
												<td class="text-center {{ ($action->statut == 'en cours') ? 'text-success' : ''}}" nowrap>{{ $action->documents() }}</td>
												<td class="text-center" nowrap>
													@if($action->statut == 'termine')
														<button class="btn btn-sm text-success">
															<i class="fa fa-2x fa-check-circle"></i>
														</button>
													@else
														<a href="/chantier/action/{{ $action->id }}" class="btn btn-sm text-info">
															<i class="fa fa-2x fa-eye"></i>
														</a>
														
														@if($user->do <> 0)
															<button class="btn btn-sm text-danger" type="button" onclick="deleteAction({{ $action->id }})">
																<i class="fa fa-2x fa-trash"></i>
															</button>
														@endif
													@endif
												</td>
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