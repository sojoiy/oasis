@foreach ($habilitations as $myHabilitation)
	<div id="h_{{ $myHabilitation->id }}" class="kt-widget4__item">
		<div class="kt-widget4__info">
			<a href="/comptes/habilitation/{{ $myHabilitation->id }}" class="kt-widget4__username">
				{{ $myHabilitation->libelle }}
			</a>
		</div>
		<button onclick="modifierHabilitation({{ $myHabilitation->id }})" class="btn btn-sm btn-info btn-bold">Voir</button>&nbsp;
		<button onclick="deleteHabilitation({{ $myHabilitation->id }})" class="btn btn-sm btn-danger btn-bold">Supprimer</button>
	</div>
@endforeach