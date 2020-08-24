
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