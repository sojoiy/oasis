@extends('layout.default')

@section('content')




<!-- begin:: Content -->
<div class="card card-custom">
								
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-12">

			<!--begin:: Widgets/New Users-->
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
					<th># <i onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'libelle') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'libelle') ? 'text-info' : ''}}"></i></th>
					<th>Nom <i onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'libelle') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'libelle') ? 'text-info' : ''}}"></i></th>
					<th>Type de vehicule</th>
					<th>Marque</th>
					<th>Modèle</th>
					<th></th>
				</tr>
				<!--table de vehicule avec ses attributs !-->
				@foreach ($elements as $element)
					<tr id="ligne_entite_{{ $element->id }}">
						<td style="width:10px;">{{ $element->id }}</td>
						<td style="width:244px;">{{ $element->name }}</td>
						<td style="width:134px;">{{ $element->type_vehicule }}</td>
						<td style="width:134px;">{{ $element->marque}}</td>
						<td style="width:194px;">{{ $element->modele }}</td>
						<td style="width:134px;" class="text-center" nowrap>
							<a href="/vehicule/show/{{ $element->id }}" class="btn btn-sm btn-info btn-icon mr-2" title="Edit details">
								<i class="fa fa-edit"></i>
							</a>
							<a href="/vehicule/delete/{{ $element->id }}" class="btn btn-sm btn-danger btn-icon mr-2" title="Edit details">
								<i class="fa fa-trash"></i>
							</a>
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

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection
