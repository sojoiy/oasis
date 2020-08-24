@foreach($equipe as $entite)
	<tr id="ligneEquipier_{{ $entite->id }}">
		<td class="text-center" scope="row" style="width:80px;">
			@if($entite->validation)
				<a href="/chantier/fic/{{ $entite->id }}"><i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content="Validation effectuée le {{ date('d/m/Y à H:i', strtotime($entite->validation)) }} par {{ $entite->auteur_validation() }}"></i></a>
			@else
				{{ $entite->id }}
			@endif
		</td>
		<td>{{ $entite->name() }} {{ $entite->prenom }} ({{ $entite->nature() }})</td>
		
		<!-- AFFICHAGE DE LA SOCIETE -->
		@if($chantier->do == $user->societeID)
			<td>{{ $entite->employeur() }}</td>
		@endif
		
		@if($chantier->do == $user->societeID)
			@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
				<td class="text-center" style="width:80px;">
					<a href="#" title="" class="btn">
						@if($entite->validation_globale($chantier->do))
							<i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
						@else
							<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
						@endif
					</a>
				</td>
			@endif
		@else
			
			@if($chantier->mecanisme == 2 || $chantier->mecanisme == 4)
				<td class="text-center" style="width:80px;">
					<a href="#" title="" class="btn">
						@if($entite->validation_globale($chantier->do))
							<i class="fa fa-check-circle text-success fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
						@else
							<i class="fa fa-exclamation-triangle text-warning fa-2x" data-toggle="kt-popover" title="Entité validée" data-content=""></i>
						@endif
					</a>
				</td>
			@endif
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