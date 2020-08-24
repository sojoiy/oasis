@extends('layout.default')

@section('content')

<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Mes Ressources</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="#" data-toggle="modal" data-target="#kt_modal_ajouterType" class="btn btn-label-info active btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-plus"></i> Ajouter un type de document
		</a>
		<a href="/entite/listertypes" class="btn btn-label-info active btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-arrow-left"></i> Retour
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<div class="modal fade" id="kt_modal_ajouterType" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-large" role="document">

		<form class="kt-form" method="POST" id="ajout_document" action="/entite/adddocument">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Ajouter un document</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id" value="{{ $typeEntite->id }}">
				{{ csrf_field() }}
				<div class="form-group row">
					<label class="col-form-label col-lg-3 col-sm-12">Libellé *</label>
					<div class=" col-lg-8 col-md-9 col-sm-12">
						<input class="form-control" type="text" name="libelle" value="" required>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-form-label col-lg-3 col-sm-12">Abbréviation</label>
					<div class=" col-lg-8 col-md-9 col-sm-12">
						<input class="form-control" type="text" name="abbr" value="" >
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-form-label col-lg-3 col-sm-12">Type</label>
					<div class=" col-lg-8 col-md-9 col-sm-12">
						<select name="nature" class="form-control">
							<option value="document">Document PDF</option>
							<option value="image">Image</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Confirmer</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">Annuler</button>
				<!-- ><button type="button" data-dismiss="modal" class="btn btn-danger">Non merci, je veux recharger mes pièces</button> -->
			</div>
		</div>
		</form>
	</div>
</div>

<!-- begin:: Content -->
<div class="card card-custom">
	@include('alert.message', ['message' => $message])
	
	<!--begin::Modal-->
	
	<!--end::Modal-->
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-6">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							{{ $typeEntite->libelle }}
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/entite/saveold">
						<input type="hidden" name="id" value="{{ $typeEntite->id }}">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Identifiant : *</label>
									<input type="text" name="libelle" required class="form-control" value="{{ $typeEntite->libelle }}" placeholder="Identifiant">
								</div>
								
								@foreach($lesChamps as $key => $unChamp)
									<div class="form-group">
										<label> {{ $key }} :</label>
										<input type="text" name="{{ $key }}" value="{{ $unChamp->name }}" class="form-control" placeholder="">
										<select class="form-control" name="type_{{ $key }}">
											<option {{ ($unChamp->type == 'texte') ? 'selected' : '' }} value="texte">Texte</option>
											<option {{ ($unChamp->type == 'date') ? 'selected' : '' }} value="date">Date</option>
											<option {{ ($unChamp->type == 'email') ? 'selected' : '' }} value="email">Email</option>
										</select>
									</div>
									
									
								@endforeach
							</div>
						</div>
						<div class="card-footer d-flex justify-content-between">
							<div class="kt-form__actions">
								<button type="submit" class="btn btn-primary">Valider</button>
								<button type="reset" class="btn btn-secondary">Annuler</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
		
		<div class="col-md-6">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Documents
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
						<thead>
							<tr>
								<th>Document</th>
								<th>Type</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="lesDocuments">
							@foreach ($typesPieces as $typesPiece)
								<tr id="ligne_{{ $typesPiece->id }}">
									<td style="width:50px;">{{ $typesPiece->libelle }}</td>
									<td style="width:50px;">{{ $typesPiece->formats }}</td>
									<td class="text-center" style="width:50px;"><buttton onclick="supprimerDocument({{ $typesPiece->id }});" class="btn btn-sm btn-danger">Supprimer</button></td>
								</tr>
							@endforeach
						</tfoot>
					</table>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	
	
	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/type_entite.js') }}" type="text/javascript"></script>
@endsection