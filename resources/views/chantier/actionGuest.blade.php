@extends('layouts.visitor')

@section('content')
@include('chantier.head_do', ['active' => 'Actions', 'guest' => true, 'url' => $url])

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-6">
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							{{ $action->libelle }}
						</h3>
					</div>
				</div>
				<form class="kt-form" method="POST" action="/chantier/saveactionGuest" enctype="multipart/form-data">
					<div class="card-body">
						<input type="hidden" name="action" value="{{ $action->id}}" />
						{{ csrf_field() }}
						<div class="form-group">
							<label>Date limite : {{ date('d/m/Y', strtotime($action->date_limite)) }}</label>
						</div>
						
						@if($action->validation <> 0 && $action->statut != "a valider")
							<div class="form-group">
								<textarea rows="10" name="description" class="form-control">{{ $action->description }}</textarea>
							</div>
							
							<div class="form-group" id="info_cloture">
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
							</div>
						@else
							<div class="form-group">
								<textarea rows="10" disabled class="form-control">{{ $action->description }}</textarea>
							</div>
							
							@if($action->validation == $intervenant->id && $action->statut == "a valider")
								<div class="form-group" id="info_cloture">
									<button type="button" onclick="terminerGuest({{ $action->id }})" class="btn btn-success"><i class="fa fa-check-circle"></i> Marquer comme terminée</button>
								</div>
							@endif
							
							@if($action->validation == 0)
								<div class="form-group" id="info_cloture">
									<button type="button" onclick="terminerGuest({{ $action->id }})" class="btn btn-success"><i class="fa fa-check-circle"></i> Marquer comme terminée</button>
								</div>
							@endif
						@endif
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-6">
			@foreach($documents as $document)
				<div class="kt-portlet" id="justificatif_{{ $document->id }}">
					<div class="card-header">
						<div class="card-title">
							<h3>
								{{ $document->libelle }} - {{ date("d/m/Y H:i", strtotime($document->created_at)) }}
							</h3>
						</div>
					</div>
					<div class="card-body">
							<div class="form-group" id="info_cloture">
								<a href="/downloadJustificatif/{{ $document->id }}" class="btn btn-sm btn-success"><i class="fa fa-download"></i>Télécharger</a>
								<button type="button" onclick="deleteFile({{ $document->id }})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>Supprimer</button>
							</div>
					</div>
				</div>
			@endforeach
		
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Charger un document
						</h3>
					</div>
				</div>
				<form class="kt-form" method="POST" action="/chantier/chargerjustificatifGuest" enctype="multipart/form-data">
					<div class="card-body">
						<input type="hidden" name="action" value="{{ $action->id}}" />
						{{ csrf_field() }}
						<div class="form-group row">
							<input type="text" name="libelle" class="form-control" placeholder="Libellé" />
						</div>
						<div class="form-group row">
							<input type="file" name="justificatif" class="form-control" />
						</div>
					</div>
					<div class="card-footer d-flex justify-content-between">
						<div class="kt-form__actions">
							<button class="btn btn-xs btn-success" type="submit">Charger</button>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>	

	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier_do.js') }}" type="text/javascript"></script>
@endsection