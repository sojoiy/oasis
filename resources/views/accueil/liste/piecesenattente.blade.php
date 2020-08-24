@extends('layout.default')

@section('content')
<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
    <div class="card-body">

        <!--begin::Search Form-->
		<form id="sortPage" method="post" action="{{ $refresh }}">
			<input type="hidden" name="num_page" value="{{ $num_page }}" />
			<input type="hidden" id="criteria_sort" name="sort" value="{{ $sort }}" />
			<input type="hidden" id="criteria_sens" name="sens" value="{{ $sens }}" />
			<input type="hidden" name="keywords" value="{{ (isset($keywords)) ? $keywords : '' }}" >
			{{ csrf_field() }}
		
            <div class="mt-2 mb-5 mt-lg-5 mb-lg-10">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-xl-6">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="keywords" value="{{ $keywords }}" placeholder="Rechercher..." id="kt_datatable_search_query"/>
                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
                                </div>
                            </div>
						
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <label class="col-md-3">Société :</label>
                                    <select class="form-control" name="societe" id="kt_datatable_search_type">
                                        <option value="">Toutes</option>
                                        @foreach($societes as $societe)
											<option value="{{ $societe->id }}">{{ $societe->raisonSociale }}</option>
										@endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                        <button type="sumbit" class="btn btn-light-primary px-6 font-weight-bold">
                            Rechercher
						</button>
                    </div>
                </div>
            </div>
		</form>
        <!--end::Search Form-->

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
				<th class="text-center">Numéro <i onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'libelle') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'libelle') ? 'text-info' : ''}}"></i></th>
				<th class="text-center">Date EXP <i onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'libelle') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'libelle') ? 'text-info' : ''}}"></i></th>
				<th class="text-center">Ajouté le</th>
				<th class="text-center">Type</th>
				<th class="text-center">Entité</th>
				<th class="text-center">Statut</th>
				<th></th>
			</tr>
			
			@foreach($elements as $piece)
				<tr>
					<td style="width:5%;" class="text-center">{{ $piece->id }}</td>
					<td style="width:10%;" class="text-center">{{ date('d/m/Y', strtotime($piece->date_expiration)) }}</td>
					<td style="width:10%;" class="text-center">{{ date('d/m/Y', strtotime($piece->created_at)) }}</td>
					<td style="width:20%;" class="text-center"><b>{{ $piece->type_piece() }}</b></td>
					<td style="width:20%;" class="text-center">{{ $piece->nomEntite() }}</td>
					<td style="width:15%;" class="text-center">{{ $piece->etat() }}</td>
					<td style="width:5%;" class="text-center" nowrap>
						<a href="/chantier/decisionpiece/{{ $piece->id }}"><i class="fa fa-check-circle fa-2x text-info"></i></a>
						<!-- <a href="/chantier/refuserpiece/{{ $piece->id }}"><i class="fa fa-times-circle fa-2x text-danger"></i></a> -->
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
<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/demo1/pages/crud/datatables/extensions/keytable.js') }}" type="text/javascript"></script>
@endsection