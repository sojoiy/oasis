@extends('layout.default')

@section('content')

    <div class="card card-custom">
		<!--
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-toolbar">
                <div class="dropdown dropdown-inline mr-2">
                    <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"/>
                                <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"/>
                            </g>
                        </svg>
                    </span>Export
                    </button>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <ul class="navi flex-column navi-hover py-2">
                            <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choisissez une option:</li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->

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
	                    <div class="col-lg-8 col-xl-8">
	                        <div class="row align-items-center">
	                            <div class="col-md-7 my-2 my-md-0">
	                                <div class="input-icon">
	                                    <input type="text" class="form-control" name="keywords" value="{{ $keywords }}" placeholder="Rechercher..." id="kt_datatable_search_query"/>
	                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
	                                </div>
	                            </div>
							
	                            <div class="col-md-5 my-2 my-md-0">
	                                <div class="d-flex align-items-center">
	                                    <label class="mr-3 mb-0 d-none d-md-block">Type de dossier :</label>
	                                    <select class="form-control" name="annee" id="kt_datatable_search_type">
	                                        <option value="">Toutes</option>
	                                        <option value="2019">2019</option>
	                                        <option value="2020">2020</option>
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
					<th>Numéro <i onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'libelle') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'libelle') ? 'text-info' : ''}}"></i></th>
					<th>Libellé <i onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'libelle') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('libelle');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'libelle') ? 'text-info' : ''}}"></i></th>
					<th>Initié par</th>
					<th>Dates</th>
					<th>Donneur d'ordre</th>
					<th>Créé  <i onclick="$('#criteria_sort').val('contact');$('#criteria_sens').val('asc');$('#sortPage').submit();" class="fa fa-angle-up {{ ($sens == 'asc' && $sort == 'contact') ? 'text-info' : ''}} "></i> <i  onclick="$('#criteria_sort').val('contact');$('#criteria_sens').val('desc');$('#sortPage').submit();" class="fa fa-angle-down {{ ($sens == 'desc' && $sort == 'contact') ? 'text-info' : ''}}"></i></th>
					<th>Modifié</th>
					<th></th>
				</tr>
				
				@foreach ($elements as $element)
					<tr id="ligne_entite_{{ $element->id }}">
						<td style="width:100px;">{{ $element->numero }}</td>
						<td style="width:200px;">{{ $element->libelle }}</td>
						<td style="width:90px;">{{ $element->initiateur() }}</td>
						<td style="width:50px;">{{ date('d/m/Y', strtotime($element->date_debut)) }} - {{ date('d/m/Y', strtotime($element->date_fin)) }}</td>
						<td style="width:90px;">{{ $element->nomDo() }}</td>
						<td style="width:90px;">{{ date('d/m/Y à H:i', strtotime($element->created_at)) }}</td>
						<td style="width:90px;">{{ date('d/m/Y à H:i', strtotime($element->updated_at)) }}</td>
						<td style="width:90px;" class="text-center" nowrap>
							<a href="/chantier/show/{{ $element->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>
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