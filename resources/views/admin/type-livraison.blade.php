@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="modal fade" id="kt_modal_atc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-large" role="document">

		<form class="kt-form" method="POST" id="ajouter_type_chantier" action="/admin/ajoutertypelivraison">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Ajouter un type de chantier</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group row">
						<label class="col-form-label col-lg-3 col-sm-12">Libellé</label>
						<div class=" col-lg-8 col-md-9 col-sm-12">
							<input class="form-control" type="text" name="libelle" value="">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-form-label col-lg-3 col-sm-12">Niveau de validation</label>
						<div class=" col-lg-8 col-md-9 col-sm-12">
							<select name="niveau_validation" class="form-control">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Valider</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">Annuler</button>
			</div>
		</div>
		</form>
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
					Liste des types de livraison
				</h3>
			</div>
			<div class="kt-portlet__head-toolbar">
				<div class="kt-portlet__head-wrapper">
					<div class="kt-portlet__head-actions">
						<div class="dropdown dropdown-inline">
							<a href="#" data-toggle="modal" data-target="#kt_modal_atc" class="btn btn-success btn-icon-sm">
								<i class="fa fa-plus"></i> Ajouter
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">
			<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
				<thead>
					<tr>
						<th class="text-center">Numéro</th>
						<th class="text-center">Libellé</th>
						<th class="text-center">Niveau de validation</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($type_chantiers as $type_chantier)
						<tr>
							<td class="text-center" style="width:30px;">{{ $type_chantier->id }}</td>
							<td style="">{{ $type_chantier->libelle }}</td>
							<td class="text-center" style="">{{ $type_chantier->niveau_validation }}</td>
							<td class="text-center" style="width:200px;" nowrap>
								<a class="btn btn-danger btn-sm" href="/admin/supprimertypelivraison/{{ $type_chantier->id }}"><i class="fa fa-trash"></i></a>
							</td>
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