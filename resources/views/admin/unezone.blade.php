@extends('layout.default')

<link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />

@section('content')
<!-- begin:: Content Head -->

<!-- end:: Content Head -->

<!-- begin:: Content -->

	<div class="row">
		<div class="col-lg-8">
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Informations</h3>
					</div>
				</div> 

				<div class="card-body">
					<form class="kt-form" method="POST" action="/admin/savezone">
						<input type="hidden" name="id" value="{{ $zone->id }}" />
						{{ csrf_field() }}
						<div class="kt-section kt-section--first">
							<div class="form-group row">
								<label class="col-lg-4 col-form-label">Libellé : *</label>
								<div class="col-lg-6">
									<input type="text" name="libelle" required value="{{ $zone->libelle }}" class="form-control" placeholder="Libellé">
								</div>
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
		</div>
	</div>
	
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js?v=7.0.5') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/pages/features/miscellaneous/treeview.js?v=7.0.5') }}" type="text/javascript"></script>
@endsection