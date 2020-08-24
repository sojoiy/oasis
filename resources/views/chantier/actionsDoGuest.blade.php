@extends('layouts.visitor')

@section('content')
@include('chantier.head_do', ['active' => 'Actions', 'guest' => true])

<!-- end:: Content Head -->
@include('chantier.modal_prorogation', ['chantier' => $chantier])

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
									<tbody id="actions_chantier">
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
													@elseif($action->qui == $intervenant->id)
														<a href="/chantier/actionGuest/{{ $action->id }}" class="btn btn-sm text-info">
															<i class="fa fa-2x fa-eye"></i>
														</a>
													@elseif($action->validation == $intervenant->id && $action->statut == "a valider")
														<a href="/chantier/actionValidateGuest/{{ $action->id }}" class="btn btn-sm text-warning">
															<i class="fa fa-2x fa-exclamation-triangle"></i>
														</a>
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