@foreach ($typesPieces as $typesPiece)
	<tr id="ligne_{{ $typesPiece->id }}">
		<td style="width:50px;">{{ $typesPiece->libelle }}</td>
		<td style="width:50px;">{{ $typesPiece->formats }}</td>
		<td class="text-center" style="width:50px;"><buttton onclick="supprimerDocument({{ $typesPiece->id }});" class="btn btn-sm btn-danger">Supprimer</button></td>
	</tr>
@endforeach