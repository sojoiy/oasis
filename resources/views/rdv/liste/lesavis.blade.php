@extends('layout.default')

@section('content')

<!-- begin:: Content -->
<div class="card card-custom">
	@foreach ($elements as $element)
	<div class="modal fade" id="kt_modal_{{ $element->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Supprimer le RDV {{ $element->numero }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
					<button type="button" data-dismiss="modal" onclick="supprimerRDV({{ $element->id }})" class="btn btn-danger">Supprimer</button>
				</div>
			</div>
		</div>
	</div>
	@endforeach
	
	<!--Begin::Section-->
	<div class="card-body">
		<div class="d-flex justify-content-between align-items-center flex-wrap">
			<div class="d-flex flex-wrap py-2 mr-3">
				
				<form method="post" action="{{ $refresh }}">
					<input type="hidden" name="num_page" value="{{ $num_page - 1 }}" />
					<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
					<input type="hidden" name="annee" value="{{ (isset($annee)) ? $annee : '' }}" >
					{{ csrf_field() }}
					<button type="submit" {{ ($num_page == 1) ? 'disabled' : '' }} class="btn btn-icon btn-sm btn-light mr-2 my-1">
					<i class="ki ki-bold-arrow-back icon-xs"></i></button>
				</form>
				
				@if($num_page > 1)
					<a href="#" class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1">{{ $num_page - 1 }}</a>
				@endif
					
				<a href="#" class="btn btn-icon btn-sm border-0 btn-light btn-hover-primary active mr-2 my-1"> {{ $num_page }}</a>
				
				@if($num_page < $nb_pages)
					<a href="#" class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1">{{ $num_page + 1 }}</a>
				@endif
				
				<form method="post" action="{{ $refresh }}">
					<input type="hidden" name="num_page" value="{{ $num_page + 1 }}" />
					<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
					<input type="hidden" name="annee" value="{{ (isset($annee)) ? $annee : '' }}" >
					{{ csrf_field() }}
					<button type="submit" {{ ($num_page == $nb_pages) ? 'disabled' : '' }} class="btn btn-icon btn-sm btn-light mr-2 my-1">
					<i class="ki ki-bold-arrow-next icon-xs"></i></i></button>
				</form>
			</div>
			<div class="d-flex align-items-center py-3">
				<form id="changerPage" method="post" action="{{ $refresh }}">
					<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
					<input type="hidden" name="annee" value="{{ (isset($annee)) ? $annee : '' }}" >
					{{ csrf_field() }}
					<select name="num_page" class="form-control form-control-sm font-weight-bold mr-4 border-0 bg-light" style="width: 175px;" onchange="$('#changerPage').submit();">
						<option value="1">-- Page --</option>
						@for($i = 1; $i <= $nb_pages ; $i++)
							<option value="{{ $i }}">Page {{ $i }}</option>
						@endfor
					</select>
					<span class="text-muted">Affichage 20 sur {{ $nb_items }}</span>
				</form>
			</div>
		</div>
					
		<table class="table table-striped table-bordered table-hover table-checkable">
			<tr>
				<th>Numéro</th>
				<th>Visiteur</th>
				<th>Société</th>
				<th>Personne visitée</th>
				<th>Initiateur</th>
				<th>Date RDV</th>
				<th>Valideurs</th>
				<th>Statut</th>
				<th></th>
			</tr>
			
			@foreach ($elements as $element)
				<tr id="ligne_element{{ $element->id }}">
					<td>{{ $element->numero }}</td>
					<td>{{ $element->nom_visiteur }} {{ $element->prenom_visiteur }} {{ $element->nombre_visiteurs() }}</td>
					<td>{{ $element->societe_visiteur }}</td>
					<td>{{ $element->nom_do }} {{ $element->prenom_do }}</td>
					<td>{{ $element->initiateur }}</td>
					<td>{{ date("d/m/Y h:i", strtotime($element->date_rdv)) }} {{ $element->nombre_creneaux() }}</td>
					<td>{{ $element->valideurs() }}</td>
					<td>{{ $element->validation() }}</td>
					<td class="text-center">
						<a href="/rdv/show/{{ $element->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
						@if($element->validation===NULL)
							<a href="#" data-toggle="modal" class="btn btn-sm btn-danger btn-bold" data-target="#kt_modal_{{ $element->id }}" tabindex="-1" id="p_{{ $element->id }}_anchor">Supprimer</a>
						@endif	
					</td>
				</tr>
			@endforeach
		</table>
		
		<div class="d-flex justify-content-between align-items-center flex-wrap">
			<div class="d-flex flex-wrap py-2 mr-3">
				
				<form method="post" action="{{ $refresh }}">
					<input type="hidden" name="num_page" value="{{ $num_page - 1 }}" />
					<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
					<input type="hidden" name="annee" value="{{ (isset($annee)) ? $annee : '' }}" >
					{{ csrf_field() }}
					<button type="submit" {{ ($num_page == 1) ? 'disabled' : '' }} class="btn btn-icon btn-sm btn-light mr-2 my-1">
					<i class="ki ki-bold-arrow-back icon-xs"></i></button>
				</form>
				
				@if($num_page > 1)
					<a href="#" class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1">{{ $num_page - 1 }}</a>
				@endif
					
				<a href="#" class="btn btn-icon btn-sm border-0 btn-light btn-hover-primary active mr-2 my-1"> {{ $num_page }}</a>
				
				@if($num_page < $nb_pages)
					<a href="#" class="btn btn-icon btn-sm border-0 btn-light mr-2 my-1">{{ $num_page + 1 }}</a>
				@endif
				
				<form method="post" action="{{ $refresh }}">
					<input type="hidden" name="num_page" value="{{ $num_page + 1 }}" />
					<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
					<input type="hidden" name="annee" value="{{ (isset($annee)) ? $annee : '' }}" >
					{{ csrf_field() }}
					<button type="submit" {{ ($num_page == $nb_pages) ? 'disabled' : '' }} class="btn btn-icon btn-sm btn-light mr-2 my-1">
					<i class="ki ki-bold-arrow-next icon-xs"></i></i></button>
				</form>
			</div>
			<div class="d-flex align-items-center py-3">
				<form id="changerPage" method="post" action="{{ $refresh }}">
					<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
					<input type="hidden" name="annee" value="{{ (isset($annee)) ? $annee : '' }}" >
					{{ csrf_field() }}
					<select name="num_page" class="form-control form-control-sm font-weight-bold mr-4 border-0 bg-light" style="width: 175px;" onchange="$('#changerPage').submit();">
						<option value="1">-- Page --</option>
						@for($i = 1; $i <= $nb_pages ; $i++)
							<option value="{{ $i }}">Page {{ $i }}</option>
						@endfor
					</select>
					<span class="text-muted">Affichage 20 sur {{ $nb_items }}</span>
				</form>
			</div>
		</div>
	</div>
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/rdv.js') }}" type="text/javascript"></script>
@endsection