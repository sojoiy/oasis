@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Chantiers virtuels</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
	</div>
	<div class="kt-subheader__toolbar">
		{{ (sizeof($chantiers) < 2) ? sizeof($chantiers).' Chantier' : sizeof($chantiers).' Chantiers' }}
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-12">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
									<thead>
										<tr>
											<th>Numéro</th>
											<th>Initié par</th>
											<th>Do</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach ($chantiers as $chantier)
											<tr>
												<td style="width:60px;"><a href="/chantier/show/{{ $chantier->id }}" class="kt-widget4__username">{{ $chantier->numero }}</a></td>
												<td style="width:90px;">{{ $chantier->initiateur() }}</td>
												<td style="width:90px;">{{ $chantier->nomDo() }}</td>
												<td style="width:80px;" class="text-center">
													<a href="/chantier/gerervirtuel/{{ $chantier->id }}" class="btn btn-sm btn-label-brand btn-bold">Intervenants</a>
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