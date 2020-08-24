@if(sizeof($equipe))
	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="width:5%;" class="text-center">#</th>
				<th style="width:20%;" class="text-left">Nom</th>
				<!-- AFFICHAGE DE LA SOCIETE -->
				@if($chantier->do == $user->societeID)
					<th class="text-left">Société</th>
				@endif
				
				@if($chantier->rdv_active())
					<th class="text-center" style="width:80px;">RDV</th>
				@endif
				
				@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
					<th class="text-center" style="width:80px;">Validation globale</th>
				@endif
				
				@foreach($chantier->pieces_immaginables('intervenant') as $piece)
					<th nowrap class="text-center" style="width:80px;">{{ $piece->abbreviation }}</th>
				@endforeach
				<th style="width:10%;" class="text-center"></th>
			</tr>
		</thead>
		<tbody id="equipe_chantier">
			@foreach($equipe as $entite)
				<tr id="ligneEquipier_{{ $entite->id }}">
					<td style="width:5%;" class="text-center" scope="row" style="width:80px;">
						@if($entite->validation && $entite->complet())
							<a href="/chantier/fic/{{ $entite->id }}"><i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content="Validation effectuée le {{ date('d/m/Y à H:i', strtotime($entite->validation)) }} par {{ $entite->auteur_validation() }}"></i></a>
						@else
							{{ $entite->id }}
						@endif
					</td>
					<td style="width:20%;">{{ $entite->name() }} {{ $entite->prenom }}</td>
					
					<!-- AFFICHAGE DE LA SOCIETE -->
					@if($chantier->do == $user->societeID)
						<td>{{ $entite->employeur() }}</td>
					@endif
					
					@if($chantier->do == $user->societeID)
						@if($chantier->rdv_active())
							<td class="text-center" style="width:80px;">
								<a href="#" title="{{ $entite->date_creneau() }}" class="btn">
									<i class="far fa-calendar-alt fa-2x text-{{ ($entite->creneau) ? 'success' : ''}}"></i>
								</a>
							</td>
						@endif
						
						@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
							<td class="text-center" style="width:80px;">
								<a href="#" title="" class="btn">
									@if($entite->validation_globale($chantier->do))
										<i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
									@else
										<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="En attente de validation" data-content=""></i>
									@endif
								</a>
							</td>
						@endif
					@else
						@if($chantier->rdv_active())
							<td class="text-center" style="width:80px;">
								<a href="/chantier/attribuer/{{ $entite->id }}" title="{{ $entite->creneau }}" class="btn">
									<i class="far fa-calendar-alt fa-2x  text-{{ ($entite->creneau) ? 'success' : ''}}"></i>
								</a>
							</td>
						@endif
						
						@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
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
					@endif
					
					@foreach($chantier->pieces_immaginables($entite->categorie) as $piece)
						<td class="text-center" style="width:80px;">
							@if($entite->checkPiece($chantier->id, $piece->id) != '')
								<button data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $entite->getStatutPiece($piece->id, $chantier->do) }}" class="btn" onclick="selectionnerEquipier({{ $entite->intervenant }}, 'name', {{ $entite->id }}, {{ $piece->id }});$('html,body').animate({scrollTop: 0}, 'slow');">
								<i class="far fa-clipboard fa-2x text-{{ $entite->checkPiece($chantier->id, $piece->id) }}"></i></button>
							@else
								&nbsp;
							@endif
						</td>
					@endforeach
					
					@if($chantier->do <> $user->societeID)
						<td style="width:10%;" class="text-center" style="width:140px;" nowrap>
							@if(!$entite->validation)
								<button title="Retirer du chantier" class="btn btn-sm" onclick="enleverEquipier({{ $chantier->id }}, {{ $entite->id }})"><i class="fa fa-times fa-2x text-danger"></i></button>
							@endif
						</td>
					@else
						<td style="width:10%;" nowrap class="text-center" style="width:140px;padding-top:15px;">
							@include('chantier.tabintervenant', ['entite' => $entite])
						</td>
					@endif
				</tr>
			@endforeach
		</tbody>
	</table>
@endif

@if(sizeof($equipe_int) || sizeof($st_int))
	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="width:5%;" class="text-center">#</th>
				<th style="width:20%;" class="text-left">Nom</th>
				<!-- AFFICHAGE DE LA SOCIETE -->
				@if($chantier->do == $user->societeID)
					<th class="text-left">Société</th>
				@endif
				
				@if($chantier->rdv_active())
					<th class="text-center" style="width:80px;">RDV</th>
				@endif
				
				@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
					<th class="text-center" style="width:80px;">Validation globale</th>
				@endif
				
				@foreach($chantier->pieces_immaginables('interim') as $piece)
					<th nowrap class="text-center" style="width:80px;">{{ $piece->abbreviation }}</th>
				@endforeach
				<th style="width:10%;" class="text-center"></th>
			</tr>
		</thead>
		<tbody id="equipe_chantier">
			@foreach($equipe_int as $entite)
				<tr id="ligneEquipier_{{ $entite->id }}">
					<td style="width:5%;" class="text-center" scope="row" style="width:80px;">
						@if($entite->validation && $entite->complet())
							<a href="/chantier/fic/{{ $entite->id }}"><i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content="Validation effectuée le {{ date('d/m/Y à H:i', strtotime($entite->validation)) }} par {{ $entite->auteur_validation() }}"></i></a>
						@else
							{{ $entite->id }}
						@endif
					</td>
					<td style="width:20%;">{{ $entite->name() }} {{ $entite->prenom }}</td>
					
					<!-- AFFICHAGE DE LA SOCIETE -->
					@if($chantier->do == $user->societeID)
						<td>{{ $entite->employeur() }}</td>
					@endif
					
					@if($chantier->do == $user->societeID)
						@if($chantier->rdv_active())
							<td class="text-center" style="width:80px;">
								<a href="#" title="{{ $entite->date_creneau() }}" class="btn">
									<i class="far fa-calendar-alt fa-2x text-{{ ($entite->creneau) ? 'success' : ''}}"></i>
								</a>
							</td>
						@endif
						
						@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
							<td class="text-center" style="width:80px;">
								<a href="#" title="" class="btn">
									@if($entite->validation_globale($chantier->do))
										<i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
									@else
										<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="En attente de validation" data-content=""></i>
									@endif
								</a>
							</td>
						@endif
					@else
						@if($chantier->rdv_active())
							<td class="text-center" style="width:80px;">
								<a href="/chantier/attribuer/{{ $entite->id }}" title="{{ $entite->creneau }}" class="btn">
									<i class="far fa-calendar-alt fa-2x  text-{{ ($entite->creneau) ? 'success' : ''}}"></i>
								</a>
							</td>
						@endif
						
						@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
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
					@endif
					
					@foreach($chantier->pieces_immaginables($entite->categorie) as $piece)
						<td class="text-center" style="width:80px;">
							@if($entite->checkPiece($chantier->id, $piece->id) != '')
								<button class="btn" onclick="selectionnerEquipier({{ $entite->intervenant }}, 'name', {{ $entite->id }}, {{ $piece->id }});$('html,body').animate({scrollTop: 0}, 'slow');">
								<i class="far fa-clipboard fa-2x text-{{ $entite->checkPiece($chantier->id, $piece->id) }}"></i></button>
							@else
								<button class="btn" onclick="selectionnerEquipier({{ $entite->intervenant }}, 'name', {{ $entite->id }}, {{ $piece->id }});$('html,body').animate({scrollTop: 0}, 'slow');">
								<i class="far fa-clipboard fa-2x text-{{ $entite->checkPiece($chantier->id, $piece->id) }}"></i></button>
							@endif
						</td>
					@endforeach
					
					@if($chantier->do <> $user->societeID)
						<td style="width:10%;" class="text-center" style="width:140px;" nowrap>
							@if(!$entite->validation)
								<button title="Retirer du chantier" class="btn btn-sm" onclick="enleverEquipier({{ $chantier->id }}, {{ $entite->id }})"><i class="fa fa-times fa-2x text-danger"></i></button>
							@endif
						</td>
					@else
						<td style="width:10%;" nowrap class="text-center" style="width:140px;padding-top:15px;">
							@include('chantier.tabintervenant', ['entite' => $entite])
						</td>
					@endif
				</tr>
			@endforeach
			
			@foreach($st_int as  $entite)
				<tr id="ligneEquipier_{{ $entite->id }}">
					<td style="width:5%;" class="text-center" scope="row" style="width:80px;">
						@if($entite->validation && $entite->complet())
							<a href="/chantier/fic/{{ $entite->id }}"><i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content="Validation effectuée le {{ date('d/m/Y à H:i', strtotime($entite->validation)) }} par {{ $entite->auteur_validation() }}"></i></a>
						@else
							{{ $entite->id }}
						@endif
					</td>
					<td style="width:20%;">{{ $entite->name() }} {{ $entite->prenom }} ({{ $entite->employeur() }})</td>
					
					<!-- AFFICHAGE DE LA SOCIETE -->
					@if($chantier->do == $user->societeID)
						<td>{{ $entite->employeur() }}</td>
					@endif
					
					@if($chantier->do == $user->societeID)
						@if($chantier->rdv_active())
							<td class="text-center" style="width:80px;">
								<a href="#" title="{{ $entite->date_creneau() }}" class="btn">
									<i class="far fa-calendar-alt fa-2x text-{{ ($entite->creneau) ? 'success' : ''}}"></i>
								</a>
							</td>
						@endif
						
						@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
							<td class="text-center" style="width:80px;">
								<a href="#" title="" class="btn">
									@if($entite->validation_globale($chantier->do))
										<i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
									@else
										<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="En attente de validation" data-content=""></i>
									@endif
								</a>
							</td>
						@endif
					@else
						@if($chantier->rdv_active())
							<td class="text-center" style="width:80px;">
								<a href="/chantier/attribuer/{{ $entite->id }}" title="{{ $entite->creneau }}" class="btn">
									<i class="far fa-calendar-alt fa-2x  text-{{ ($entite->creneau) ? 'success' : ''}}"></i>
								</a>
							</td>
						@endif
						
						@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
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
					@endif
					
					@foreach($chantier->pieces_immaginables($entite->categorie) as $piece)
						<td class="text-center" style="width:80px;">
							@if($entite->checkPiece($chantier->id, $piece->id) != '')
								<button class="btn" onclick="selectionnerEquipier({{ $entite->intervenant }}, 'name', {{ $entite->id }}, {{ $piece->id }});$('html,body').animate({scrollTop: 0}, 'slow');">
								<i class="far fa-clipboard fa-2x text-{{ $entite->checkPiece($chantier->id, $piece->id) }}"></i></button>
							@else
								<button class="btn" onclick="selectionnerEquipier({{ $entite->intervenant }}, 'name', {{ $entite->id }}, {{ $piece->id }});$('html,body').animate({scrollTop: 0}, 'slow');">
								<i class="far fa-clipboard fa-2x text-{{ $entite->checkPiece($chantier->id, $piece->id) }}"></i></button>
							@endif
						</td>
					@endforeach
					
					@if($chantier->do <> $user->societeID)
						<td style="width:10%;" class="text-center" style="width:140px;" nowrap>
							@if(!$entite->validation)
								<button title="Retirer du chantier" class="btn btn-sm" onclick="enleverEquipier({{ $chantier->id }}, {{ $entite->id }})"><i class="fa fa-times fa-2x text-danger"></i></button>
							@endif
						</td>
					@else
						<td style="width:10%;" nowrap class="text-center" style="width:140px;padding-top:15px;">
							@include('chantier.tabintervenant', ['entite' => $entite])
						</td>
					@endif
				</tr>
			@endforeach
		</tbody>
	</table>
@endif

@if(sizeof($equipe_etr))
	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="width:5%;" class="text-center">#</th>
				<th style="width:20%;" class="text-left">Nom</th>
				<!-- AFFICHAGE DE LA SOCIETE -->
				@if($chantier->do == $user->societeID)
					<th class="text-left">Société</th>
				@endif
				
				@if($chantier->rdv_active())
					<th class="text-center" style="width:80px;">RDV</th>
				@endif
				
				@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
					<th class="text-center" style="width:80px;">Validation globale</th>
				@endif
				
				@foreach($chantier->pieces_immaginables('etranger') as $piece)
					<th nowrap class="text-center" style="width:80px;">{{ $piece->abbreviation }}</th>
				@endforeach
				<th style="width:10%;" class="text-center"></th>
			</tr>
		</thead>
		<tbody id="equipe_chantier">
			@foreach($equipe_etr as $entite)
				<tr id="ligneEquipier_{{ $entite->id }}">
					<td style="width:5%;" class="text-center" scope="row" style="width:80px;">
						@if($entite->validation)
							<a href="/chantier/fic/{{ $entite->id }}"><i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content="Validation effectuée le {{ date('d/m/Y à H:i', strtotime($entite->validation)) }} par {{ $entite->auteur_validation() }}"></i></a>
						@else
							{{ $entite->id }}
						@endif
					</td>
					<td style="width:20%;">{{ $entite->name() }} {{ $entite->prenom }} ({{ $entite->nature() }})</td>
					
					<!-- AFFICHAGE DE LA SOCIETE -->
					@if($chantier->do == $user->societeID)
						<td>{{ $entite->employeur() }}</td>
					@endif
					
					@if($chantier->do == $user->societeID)
						@if($chantier->rdv_active())
							<td class="text-center" style="width:80px;">
								<a href="#" title="{{ $entite->date_creneau() }}" class="btn">
									<i class="far fa-calendar-alt fa-2x text-{{ ($entite->creneau) ? 'success' : ''}}"></i>
								</a>
							</td>
						@endif
						
						@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
							<td class="text-center" style="width:80px;">
								<a href="#" title="" class="btn">
									@if($entite->validation_globale($chantier->do))
										<i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
									@else
										<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="En attente de validation" data-content=""></i>
									@endif
								</a>
							</td>
						@endif
					@else
						@if($chantier->rdv_active())
							<td class="text-center" style="width:80px;">
								<a href="/chantier/attribuer/{{ $entite->id }}" title="{{ $entite->creneau }}" class="btn">
									<i class="far fa-calendar-alt fa-2x  text-{{ ($entite->creneau) ? 'success' : ''}}"></i>
								</a>
							</td>
						@endif
						
						@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
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
					@endif
					
					@foreach($chantier->pieces_immaginables($entite->categorie) as $piece)
						<td class="text-center" style="width:80px;">
							@if($entite->checkPiece($chantier->id, $piece->id) != '')
								<button class="btn" onclick="selectionnerEquipier({{ $entite->intervenant }}, 'name', {{ $entite->id }}, {{ $piece->id }});$('html,body').animate({scrollTop: 0}, 'slow');">
								<i class="far fa-clipboard fa-2x text-{{ $entite->checkPiece($chantier->id, $piece->id) }}"></i></button>
							@else
								&nbsp;
							@endif
						</td>
					@endforeach
					
					@if($chantier->do <> $user->societeID)
						<td style="width:10%;" class="text-center" style="width:140px;" nowrap>
							@if(!$entite->validation)
								<button title="Retirer du chantier" class="btn btn-sm" onclick="enleverEquipier({{ $chantier->id }}, {{ $entite->id }})"><i class="fa fa-times fa-2x text-danger"></i></button>
							@endif
						</td>
					@else
						<td style="width:10%;" nowrap class="text-center" style="width:140px;padding-top:15px;">
							@include('chantier.tabintervenant', ['entite' => $entite])
						</td>
					@endif
				</tr>
			@endforeach
		</tbody>
	</table>
@endif