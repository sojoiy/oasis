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
					Liste des pièces à valider
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
			<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
				<thead>
					<tr>
						<th>Numéro</th>
						<th>Chantier</th>
						<th>Date limite</th>
						<th>Type</th>
						<th>Entité</th>
						<th>Statut</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($pieces as $piece)
						<tr>
							<td style="width:30px;">{{ $piece->id }}</td>
							<td style="width:60px;">{{ $piece->numeroChantier() }}</td>
							<td style="width:50px;">{{ date('d/m/Y', strtotime($piece->date_expiration)) }}</td>
							<td style="width:90px;"><b>{{ $piece->type_piece() }}</b></td>
							<td style="width:90px;">{{ $piece->nomEntite() }}</td>
							<td style="width:90px;">{{ $piece->etat() }}</td>
							<td style="width:80px;" class="text-center">
								<a href="/admin/decisionpiece/{{ $piece->id }}"><i class="fa fa-check-circle fa-2x text-info"></i></a>
								<a href="#"><i class="fa fa-times-circle fa-2x text-danger"></i></a>
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