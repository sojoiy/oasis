@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Chantiers virtuels</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/chantier/listeglobale" class="btn btn-label-success btn-bold btn-sm btn-icon-h kt-margin-l-10">
			<i class="fa fa-arrow-left"></i> Retour
		</a>
		<a href="/chantier/createv" class="btn btn-label-success btn-bold btn-sm btn-icon-h kt-margin-l-10">
			<i class="fa fa-plus"></i> Créer un chantier
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		{{ (sizeof($chantiers) < 2) ? sizeof($chantiers).' Chantier' : sizeof($chantiers).' Chantiers' }}
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	@foreach ($chantiers as $chantier)
	<div class="modal fade" id="kt_modal_{{ $chantier->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Supprimer le dossier {{ $chantier->numero }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
					<button type="button" data-dismiss="modal" onclick="supprimerChantier({{ $chantier->id }})" class="btn btn-danger">Supprimer</button>
				</div>
			</div>
		</div>
	</div>
	@endforeach
	
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
											<th>Prestataire</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach ($chantiers as $chantier)
											<tr>
												<td style="width:60px;"><a href="/chantier/show/{{ $chantier->id }}" class="kt-widget4__username">{{ $chantier->numero }}</a></td>
												<td style="width:90px;">{{ $chantier->initiateur() }}</td>
												<td style="width:90px;">{{ $chantier->nomTitulaire() }}</td>
												<td style="width:80px;" class="text-center">
													<a href="/chantier/supprimer/{{ $chantier->id }}" class="btn btn-sm btn-label-brand btn-bold">Supprimer</a>
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