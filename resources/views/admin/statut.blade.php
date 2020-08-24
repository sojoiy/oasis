<div class="kt-portlet">
	<div class="card-header">
		<div class="card-title">
			<h3>
				Compte 
			</h3>
		</div>
	</div>

	<!--begin::Form-->
	<div class="card-body">
		<div class="kt-section kt-section--first">
			<div class="form-group">
				<div class="form-group">
					<label>Identifiant :</label>
					<input type="text" name="identifiant" value="{{ $societe->identifiant() }}" disabled class="form-control" placeholder="Nom">
				</div>
				<div class="form-group">
					<label>Date création :</label>
					<input type="text" name="identifiant" value="{{ date('d/m/Y - H:i', strtotime($societe->created_at)) }}" disabled class="form-control" placeholder="Nom">
				</div>
				<div class="form-group">
					<label>Expiration mot de passe :</label>
					<input type="text" name="identifiant" value="{{ date('d/m/Y - H:i', strtotime($societe->compte()->expires)) }}" disabled class="form-control" placeholder="Nom">
				</div>
				<div class="form-group">
					<label>Dernière connexion :</label>
					<input type="text" name="identifiant" value="{{ date('d/m/Y - H:i', strtotime($societe->compte()->last_login)) }}" disabled class="form-control" placeholder="Nom">
				</div>
				
				<label>Statut</label>
				<div class="kt-checkbox-inline">
					<label class="kt-checkbox">
						<input disabled type="checkbox" {{ ($societe->active == 0) ? 'checked' : ''}}> En attente
						<span></span>
					</label>
					<label class="kt-checkbox">
						<input disabled type="checkbox" {{ ($societe->active == 1) ? 'checked' : ''}}> Valide
						<span></span>
					</label>
					<label class="kt-checkbox">
						<input disabled type="checkbox" {{ ($societe->active == 2) ? 'checked' : ''}}> Bloqué
						<span></span>
					</label>
				</div>
			</div>
		</div>
	</div>
	
	@if($societe->active == 0)
		<div class="card-footer d-flex justify-content-between">
			<div class="kt-form__actions">
				<button type="button" onclick="changerStatut({{ $societe->id }}, 1)" class="btn btn-success">Activer</button>
				<button type="button" onclick="resetPassword({{ $societe->id }})" class="btn btn-warning"><i class="fa fa-key"></i> Renvoyer mot de passe</button>
			</div>
		</div>
	@endif
	
	@if($societe->active == 1)
		<div class="card-footer d-flex justify-content-between">
			<div class="kt-form__actions">
				<button type="button" onclick="changerStatut({{ $societe->id }}, 2)" class="btn btn-danger">Bloquer</button>
				<button type="button" onclick="resetPassword({{ $societe->id }})" class="btn btn-warning"><i class="fa fa-key"></i> Renvoyer mot de passe</button>
			</div>
		</div>
	@endif
	
	@if($societe->active == 2)
		<div class="card-footer d-flex justify-content-between">
			<div class="kt-form__actions">
				<button type="button" onclick="changerStatut({{ $societe->id }}, 1)" class="btn btn-success">Activer</button>
				<button type="button" onclick="resetPassword({{ $societe->id }})" class="btn btn-warning"><i class="fa fa-key"></i> Renvoyer mot de passe</button>
			</div>
		</div>
	@endif
	<!--end::Form-->
</div>