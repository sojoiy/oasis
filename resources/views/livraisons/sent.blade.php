@extends('layout.default')

@section('content')

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-12">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Livraisons reçues
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
									<thead>
										<tr>
											<th>Numéro</th>
											<th>Libellé</th>
											<th>Dates</th>
											<th>Donneur d'ordre</th>
											<th>Date création</th>
											<th>Statut</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach ($livraisons as $chantier)
											<tr>
												<td style="width:60px;"><a href="/livraisons/show/{{ $chantier->id }}" class="kt-widget4__username">{{ $chantier->numero }}</a></td>
												<td style="width:50px;">{{ $chantier->libelle }}</td>
												<td style="width:50px;">{{ date('d/m/Y', strtotime($chantier->date_debut)) }} - {{ date('d/m/Y', strtotime($chantier->date_fin)) }}</td>
												<td style="width:90px;">{{ $chantier->nomDo() }}</td>
												<td style="width:90px;">{{ date('d/m/Y à H:i', strtotime($chantier->created_at)) }}</td>
												<td style="width:90px;">{{ $chantier->statut() }}</td>
												<td style="width:80px;" class="text-center">
													<a href="/livraisons/show/{{ $chantier->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>
												</td>
											</tr>
										@endforeach
									</tfoot>
								</table>
							</div>
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

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection