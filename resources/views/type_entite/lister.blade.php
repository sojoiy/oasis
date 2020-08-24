@extends('layout.default')

@section('content')

<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Mes entités</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		
		<form action="/entite/listertypes" method="post">
		{{ csrf_field() }}
		<div class="kt-input-icon kt-input-icon--right kt-subheader__search">
			<input type="text" name="keywords" class="form-control" value="{{ (isset($keywords)) ? $keywords : '' }}" placeholder="Rechercher..." id="generalSearch">
			<span class="kt-input-icon__icon kt-input-icon__icon--right">
				<span><i class="fa fa-search"></i></span>
			</span>
		</div>
		</form>
		
		<a href="/entite/createtype" class="btn btn-label-info active btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-plus"></i> Nouveau
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- begin:: Content -->
<div class="card card-custom">
								
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-12">
			<!--begin:: Widgets/New Users-->
			<div class="kt-portlet kt-portlet--height-fluid">
				<div class="card-header">
					<div class="card-title">
						<h3>
							LISTE DES TYPES D'ENTITES
						</h3>
					</div>
				</div>
				<div class="card-body">
					<form id="sortPage" method="post" action="/entite/listertypes">
						<input type="hidden" name="num_page" value="{{ $num_page }}" />
						<input type="hidden" id="criteria_sort" name="sort" value="{{ $sort }}" />
						<input type="hidden" id="criteria_sens" name="sens" value="{{ $sens }}" />
						<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
						{{ csrf_field() }}
					</form>
					
					<table class="table table-striped table-bordered table-hover table-checkable">
						<tr>
							<th>Libellé <i onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'libelle') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'libelle') ? 'text-info' : ''}}"></i></th>
							<th>Créé  <i onclick="$('#criteria_sort').val('contact');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'contact') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('contact');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'contact') ? 'text-info' : ''}}"></i></th>
							<th>Modifié</th>
							<th></th>
						</tr>
						
						@foreach ($typeEntites as $typeEntite)
							<tr id="ligne_entite_{{ $typeEntite->id }}">
								<td>{{ $typeEntite->libelle }}</td>
								<td>{{ $typeEntite->created_at }}</td>
								<td>{{ $typeEntite->updated_at }}</td>
								<td class="text-center">
									<a href="/entite/typeentite/{{ $typeEntite->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
									<button onclick="supprimerTypeEntite({{ $typeEntite->id }});" class="btn btn-sm btn-danger btn-bold">Supprimer</button>
								</td>
							</tr>
						@endforeach
					</table>
					
					<div class="row">
						<form method="post" action="/entite/listertypes">
							<input type="hidden" name="num_page" value="{{ $num_page - 1 }}" />
							<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
							{{ csrf_field() }}
							<button type="submit" {{ ($num_page == 1) ? 'disabled' : '' }} class="btn btn-sm"><i class="fa fa-2x fa-chevron-left"></i></button>
						</form>
							Page {{ $num_page }} / {{ $nb_pages }} 
						<form method="post" action="/entite/listertypes">
							<input type="hidden" name="num_page" value="{{ $num_page + 1 }}" />
							<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
							{{ csrf_field() }}
							<button type="submit" {{ ($num_page == $nb_pages) ? 'disabled' : '' }} class="btn btn-sm"><i class="fa fa-2x fa-chevron-right"></i></button>
						</form>
					</div>
					<div class="row">
						<form id="changerPage" method="post" action="/entite/listertypes">
							{{ csrf_field() }}
							<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
							<select name="num_page" class="form-control" onchange="$('#changerPage').submit();">
								<option value="1">-- Page --</option>
								@for($i = 1; $i <= $nb_pages ; $i++)
									<option value="{{ $i }}">Page {{ $i }}</option>
								@endfor
							</select>
						</form>
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

@section('specifijs')
	<script src="{{ asset('assets/js/type_entite.js') }}" type="text/javascript"></script>
@endsection