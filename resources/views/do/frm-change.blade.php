@extends('layout.default')

@section('content')
<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	@if($message != "EMPTY")
		<div class="alert alert-warning fade show" role="alert">
			<div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
			<div class="alert-text">{{ $message }}</div>
			<div class="alert-close">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"><i class="fa fa-times"></i></span>
				</button>
			</div>
		</div>
	@endif
	
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
							{{ $compte->name }} ({{ $compte->nomSociete() }})
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/comptes/change">
						<input type="hidden" name="id" value="{{ $compte->id }}" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Nom : *</label>
									<input type="text" name="nom" value="{{ $compte->nom }}" required class="form-control" placeholder="Nom">
								</div>
								<div class="form-group">
									<label>Prénom :</label>
									<input type="text" name="prenom" value="{{ $compte->prenom }}" class="form-control" placeholder="Prénom">
								</div>
								<div class="form-group">
									<label>Email :</label>
									<input type="text" name="email" value="{{ $compte->email }}" class="form-control" placeholder="Email">
								</div>
								<div class="form-group">
									<label>Téléphone :</label>
									<input type="text" name="telephone" value="{{ $compte->telephone }}" class="form-control" placeholder="Téléphone">
								</div>
								<div class="form-group">
									<label>Service :</label>
									<select class="form-control" name="service">
										@foreach($services as $service)
											<option {{ ($service->id == $compte->service) ? 'selected' : '' }} value="{{ $service->id }}">{{ $service->libelle }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Groupe :</label>
									<select class="form-control" name="profil">
										@foreach($profils as $profil)
											<option {{ ($profil->id == $compte->profil) ? 'selected' : '' }} value="{{ $profil->id }}">{{ $profil->libelle }}</option>
										@endforeach
									</select>
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

			<!--end:: Widgets/New Users-->
		</div>
		
		<div class="col-md-6">
			<!--begin:: Widgets/Download Files-->
			<div class="kt-portlet" id="activite">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Activité
						</h3>
					</div>
				</div>
				<div class="card-body">
					<p>Compte créé le : {{ date('d/m/Y', strtotime($compte->created_at ))}}</p>
					<p>Dernière connexion : </p>
					<a href="#">Liste des dernières connexions</a>
				</div>
			</div>
			<!--end::Widget 9-->
			<!--end:: Widgets/Download Files-->
			
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Droits & Sécurité
						</h3>
					</div>
				</div>
				
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/intervenant/change">
						<input type="hidden" name="id" value="{{ $compte->id }}" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group row">
									<label class="col-4  col-form-label">Validation des pièces : *</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" onchange="changeStatus({{ $compte->id }}, 'validation_pieces')" {{ $compte->validation_pieces ? 'checked' : '' }} name="validation_pieces" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-4  col-form-label">Validation des intervenants : *</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" onchange="changeStatus({{ $compte->id }}, 'validation_entites')" {{ $compte->validation_entites ? 'checked' : '' }} name="validation_entites" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-4  col-form-label">Validation globale : *</label>
									<div class="col-3">
										<span class="kt-switch">
											<label>
												<input type="checkbox" onchange="changeStatus({{ $compte->id }}, 'validation_globale')" {{ $compte->validation_globale ? 'checked' : '' }} name="validation_globale" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer d-flex justify-content-between">
							<div class="kt-form__actions">
								<button type="button" onclick="alert('{{ $compte->fonction }}')" class="btn btn-primary"><i class="fa fa-key"></i> Réinitialiser le mot de passe</button>
								<button type="reset" class="btn btn-danger"><i class="fa fa-lock"></i> Bloquer le compte</button>
							</div>
						</div>
					</form>
				</div>

				<!--end::Form-->
			</div>
		</div>
	</div>
	
	
	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/do.js') }}" type="text/javascript"></script>
@endsection