@extends('layout.default')

@section('content')

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
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
				<th>Nom <i onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'libelle') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'libelle') ? 'text-info' : ''}}"></i></th>
				<th>Email</th>
				<th class="text-center">Validation pièces</th>
				<th class="text-center">Validation intervenants</th>
				<th class="text-center">Validation globale</th>
				<th class="text-center">Créé le <i onclick="$('#criteria_sort').val('contact');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'contact') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('contact');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'contact') ? 'text-info' : ''}}"></i></th>
				<th></th>
			</tr>
			
			@foreach ($elements as $element)
				<tr id="ligne_entite_{{ $element->id }}">
					<td>{{ $element->name }}</td>
					<td>{{ $element->email }}</td>
					<td class="text-center">{{ ($element->validation_pieces) ? 'Oui' : 'Non' }}</td>
					<td class="text-center">{{ ($element->validation_entites) ? 'Oui' : 'Non' }}</td>
					<td class="text-center">{{ ($element->validation_globale) ? 'Oui' : 'Non' }}</td>
					<td class="text-center">{{ date('d/m/Y H:i', strtotime($element->created_at)) }}</td>
					<td class="text-center">
						<a href="/comptes/show/{{ $element->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
						@if($element->id <> $user->id)
							<a href="/comptes/delete/{{ $element->id }}" class="btn btn-sm btn-danger btn-bold">Supprimer</a>
						@else
							<a href="#" class="btn btn-sm btn-default btn-bold">Supprimer</a>
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
<!--End::Section-->
@endsection
