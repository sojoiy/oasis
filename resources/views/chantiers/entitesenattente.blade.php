@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title"><i class="fa fa-id-card"></i> Entités à valider</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		{{ sizeof($entites) }} entités en attente
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
								
	<div class="kt-portlet kt-portlet--mobile">
		<div class="kt-portlet__head kt-portlet__head--lg">
			<div class="card-title">
				<span class="kt-portlet__head-icon">
					<i class="kt-font-brand flaticon2-line-chart"></i>
				</span>
				<h3>
					Liste des entités à valider
				</h3>
			</div>
			<div class="kt-portlet__head-toolbar">
				<div class="kt-portlet__head-wrapper">
					<div class="kt-portlet__head-actions">
						<div class="dropdown dropdown-inline">
							<button type="button" class="btn btn-default btn-icon-sm">
								<i class="fa fa-download"></i> Exporter
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">

			<!--begin: Datatable -->
			<table class="table table-striped table-bordered table-hover" id="kt_table_1">
				<thead>
					<tr>
						<th style="width:10px;" class="text-center">Numéro</th>
						<th class="text-center">Nom</th>
						<th class="text-center">Société</th>
						<th class="text-center">Statut</th>
						<th class="text-center"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($entites as $entite)
						<tr>
							<td style="width:5%;" class="text-center">{{ $entite->id }}</td>
							<td style="width:15%;" class="text-center">{{ $entite->name() }}</td>
							<td style="width:15%;" class="text-center">{{ $entite->societe() }}</td>
							<td style="width:15%;" class="text-center">{{ $entite->etat() }}</td>
							<td style="width:5%;" class="text-center" nowrap>
								<a href="/chantiers/validerentite/{{ $entite->id }}"><i class="fa fa-check-circle fa-2x text-info"></i></a>
								<a href="/chantiers/invaliderentite/{{ $entite->id }}"><i class="fa fa-times-circle fa-2x text-danger"></i></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>
<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/demo1/pages/crud/datatables/extensions/keytable.js') }}" type="text/javascript"></script>
@endsection