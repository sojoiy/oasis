@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">{{ $user->nomSociete() }}</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $user->name }}</span>
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
					Liste des demandes sans rendez-vous
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
						&nbsp;
						<a href="#" class="btn btn-brand btn-elevate btn-icon-sm">
							<i class="la la-plus"></i>
							New Record
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
				<thead>
					<tr>
						<th>Numéro</th>
						<th>Dossier</th>
						<th>Date limite</th>
						<th>Type</th>
						<th>Libellé</th>
						<th>Intervenant</th>
						<th>Prestataire</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($rdvs as $rdv)
						<tr>
							<td>{{ $rdv->id }}</td>
							<td>{{ $rdv->chantier()->numero }}</td>
							<td>{{ $rdv->chantier()->date_limite }}</td>
							<td>{{ $rdv->chantier()->type_chantier() }}</td>
							<td>{{ $rdv->chantier()->libelle }}</td>
							<td>{{ $rdv->name() }}</td>
							<td>{{ $rdv->employeur() }}</td>
							<td style="width:80px;" class="text-center">
								<a href="/chantier/attribuer/{{ $rdv->id }}"><i class="fa fa-calendar fa-2x text-info"></i></a>
							</td>
						</tr>
					@endforeach
				</tfoot>
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