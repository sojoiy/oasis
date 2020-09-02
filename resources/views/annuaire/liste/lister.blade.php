@extends('layout.default')

@section('content')

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
					<th>Numéro <i onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'libelle') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'libelle') ? 'text-info' : ''}}"></i></th>
					<th>Libellé <i onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'libelle') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'libelle') ? 'text-info' : ''}}"></i></th>
					<th>Initié par</th>
					<th>Dates</th>
					<th></th>
				</tr>
			
				@foreach ($elements as $element)
					<tr id="ligne_entite_{{ $element->id }}">
						<td style="width:100px;">{{ $element->name }}</td>
						<td style="width:200px;">{{ $element->date_naissance }}</td>
						<td style="width:90px;">{{ $element->societe() }}</td>
						<td style="width:90px;">{{ $element->nationalite() }}</td>
						<td style="width:90px;" class="text-center" nowrap>
							<a href="/annuaire/show/{{ $element->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>
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
    </div>
	
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection