@extends('layout.default')

@section('content')
@include('chantier.head', ['active' => 'Intervenants'])

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-12">
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							L'équipe de ce chantier
						</h3>
					</div>
				</div>
				<div class="card-body">

					<!--begin::Section-->
					<div class="kt-section">
						@if($chantier->do <> $user->societeID)
							<div class="kt-section__info">
								Constituez ici l'équipe pour le chantier <code>{{ $chantier->libelle }}</code>.
								<select class="form-control chosen" onchange="ajouterEquipier({{ $chantier->id }}, this.value)" id="selectEquipier" name="equipier">
									<option value="0">-- Ajouter un membre --</option>
									@foreach($remplacants as $entite)
										<option id="ligneEntite_{{ $entite->id }}" value="{{ $entite->id }}">{{ $entite->name }}</option>
									@endforeach
								</select>
							</div>
						@endif
						
						<div class="kt-section__content">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th class="text-left">Nom</th>
											<!-- AFFICHAGE DE LA SOCIETE -->
											@if($chantier->do == $user->societeID)
												<th class="text-left">Société</th>
											@endif
											
											<th class="text-center" style="width:80px;">Validation globale</th>
											
											@foreach($chantier->pieces_immaginables() as $piece)
												<th class="text-center" style="width:80px;">{{ $piece->abbreviation }}</th>
											@endforeach
											<th class="text-center"></th>
										</tr>
									</thead>
									<tbody id="equipe_chantier">
										@foreach($equipe as $entite)
											<tr id="ligneEquipier_{{ $entite->id }}">
												<td>{{ $entite->name() }} {{ $entite->prenom }} ({{ $entite->nature() }})</td>
												
												<!-- AFFICHAGE DE LA SOCIETE -->
												@if($chantier->do == $user->societeID)
													<td>{{ $entite->employeur() }}</td>
												@endif
												
												@if($chantier->do == $user->societeID)
													<td class="text-center" style="width:80px;">
														<a href="#" title="{{ $entite->date_creneau() }}" class="btn">
															<i class="far fa-calendar-alt fa-2x text-{{ ($entite->creneau) ? 'success' : ''}}"></i>
														</a>
													</td>
													
													<td class="text-center" style="width:80px;">
														<a href="#" title="" class="btn">
															@if($entite->validation_globale($chantier->do))
																<i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
															@else
																<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="En attente de validation" data-content=""></i>
															@endif
														</a>
													</td>
												@else
													<td class="text-center" style="width:80px;">
														<a href="#" title="" class="btn">
															@switch($entite->validation_globale($chantier->do))
																
																@case("pending")
																	<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="{{ $entite->validation_globale($chantier->do) }}" data-content=""></i>
																	@break
																	
																@case("authorized")
																	<i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Accepté" data-content=""></i>
																	@break
																	
																@case("rejected")
																	<i class="fa fa-ban text-danger fa-2x" data-toggle="kt-popover" title="Refusé" data-content=""></i>
																	@break
																@default
																	<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="{{ $entite->validation_globale($chantier->do) }}" data-content=""></i>
															
															@endswitch
														</a>
													</td>
												@endif
												
													@foreach($chantier->pieces_immaginables() as $piece)
														<td class="text-center" style="width:80px;">
															<button class="btn" onclick="selectionnerEquipier({{ $entite->intervenant }}, 'name', {{ $entite->id }}, {{ $piece->id }});$('html,body').animate({scrollTop: 0}, 'slow');">
															<i class="far fa-clipboard fa-2x text-{{ $entite->checkPiece($chantier->id, $piece->id) }}"></i></button>
														</td>
													@endforeach
												
												@if($chantier->do <> $user->societeID)
													<td class="text-center" style="width:140px;" nowrap>
														@if(!$entite->validation)
															<button title="Retirer du chantier" class="btn btn-sm" onclick="enleverEquipier({{ $chantier->id }}, {{ $entite->id }})"><i class="fa fa-times fa-2x text-danger"></i></button>
														@endif
													</td>
												@else
													<td nowrap class="text-center" style="width:140px;padding-top:15px;">
														@include('chantier.tabintervenant', ['entite' => $entite])
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
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection