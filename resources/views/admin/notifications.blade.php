@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Notifications</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->
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
			<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
				<thead>
					<tr>
						<th>Numéro</th>
						<th>Chantier</th>
						<th>Prestataire</th>
						<th>Entite</th>
						<th>Date</th>
						<th>Texte</th>
					</tr>
				</thead>
				<tbody>
					@foreach($notifications as $notification)
						<tr>
							<td style="width:30px;">{{ $notification->id }}</td>
							<td style="">{{ $notification->chantier() }}</td>
							<td style="">{{ $notification->prestataire() }}</td>
							<td style="">{{ $notification->entite() }}</td>
							<td style="">{{ date("d/m/Y H:i", strtotime($notification->created_at)) }}</td>
							<td style="">{{ $notification->message }}</td>
						</tr>
					@endforeach
				</tfoot>
			</table>
		</div>
	</div>
</div>
						
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/input-mask.js') }}" type="text/javascript"></script>
@endsection