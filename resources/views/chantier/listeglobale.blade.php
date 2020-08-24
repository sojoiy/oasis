@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Validation globale</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/autorisation/chantiers" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
			Chantiers virtuels 
		</a>
		
		<form action="chantier/listeglobale" method="post">
		{{ csrf_field() }}
		<div class="kt-input-icon kt-input-icon--right  typeahead kt-subheader__search">
			<input type="text" name="keywords" class="form-control" placeholder="Rechercher..." id="kt_typeahead_1">
			<span class="kt-input-icon__icon kt-input-icon__icon--right">
				<span><i class="fa fa-search"></i></span>
			</span>
		</div>
		</form>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>


<div class="card card-custom">
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-12">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="card-title">
						<span class="kt-portlet__head-icon">
							<i class="kt-font-brand flaticon2-line-chart"></i>
						</span>
						<h3>
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<div class="kt-portlet__head-wrapper">
							<div class="kt-portlet__head-actions">
								<div class="dropdown dropdown-inline">
									<a href="/chantier/listeglobale" class="btn btn-info btn-icon-sm">
										<i class="fa fa-hourglass"></i> En attente
									</a>
								</div>
								
								<div class="dropdown dropdown-inline">
									<a href="/chantier/listeglobale/renew" class="btn btn-primary btn-icon-sm">
										<i class="fa fa-redo"></i> Renouvellement
									</a>
								</div>
								
								<div class="dropdown dropdown-inline">
									<a href="/chantier/listeglobale/tous" class="btn btn-success btn-icon-sm">
										<i class="fa fa-users"></i> Tous
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
									<thead>
										<tr>
											<th>Nom - Prénom</th>
											<th>Société</th>
											<th>Statut</th>
											<th>Date fin de validité</th>
											<th>Date fin d'invalidité</th>
											
											@if(in_array('enquete_administrative', $pieces))
												<th class="text-center">EA</th>
											@endif
											
											@if(in_array('enquete_interne', $pieces))
												<th class="text-center">EI</th>
											@endif
											
											@if(in_array('avis_interne', $pieces))
												<th class="text-center">AI</th>
											@endif
											
											<th>Infos</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($autorisations as $autorisation)
											<tr>
												<td style="width:20%;">{{ $autorisation->identite() }}</td>
												<td style="width:20%;">{{ $autorisation->societe() }}</td>
												<td style="width:10%;">{{ $autorisation->libelle_statut() }}</td>
												<td style="width:10%;">{{ ($autorisation->date_fin != NULL) ? date('d/m/Y', strtotime($autorisation->date_fin)) : '' }}</td>
												<td style="width:10%;">{{ ($autorisation->date_fin_invalidite != NULL) ? date('d/m/Y', strtotime($autorisation->date_fin_invalidite)) : '' }}</td>
												
												@if(in_array('enquete_administrative', $pieces))
													<td style="width:5%;" class="text-center">@if($autorisation->enquete_administrative == 2)<i class="fa fa-ban text-danger"></i>@endif {{ $autorisation->date_ea() }}</td>
												@endif
											
												@if(in_array('enquete_interne', $pieces))
													<td style="width:5%;" class="text-center">{{ $autorisation->date_ei() }}</td>
												@endif
											
												@if(in_array('avis_interne', $pieces))
													<td style="width:5%;" class="text-center">{{ $autorisation->date_ai() }}</td>
												@endif
												
												<td style="width:5%;" nowrap class="text-center">
													<a href="/chantier/voirautorisation/{{ $autorisation->id }}" class=""><i class="fa fa-2x text-info fa-info-circle"></i></a>
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
</div>
@endsection

@section('specifijs')

    <script>
		var autorisations = [
			@foreach ($autorisations as $autorisation)
				'{{ $autorisation->identite() }}',
			@endforeach
        ];
	</script>

	<script src="{{ asset('assets/js/pages/crud/forms/widgets/typeahead.js') }}" type="text/javascript"></script>
@endsection