	<div class="kt-portlet">
		<div class="card-header">
			<div class="card-title">
				<h3>
					Validation
				</h3>
			</div>
		</div>

		<!--begin::Form-->
		<form class="kt-form kt-form--label-right" id="decision-piece" method="POST">
			<input type="hidden" name="id" value="{{ $piece->id }}" />
			<input type="hidden" name="etat" value="valide" id="decision" />
			{{ csrf_field() }}
			<div class="card-body">
				<div class="form-group row">
					<label class="col-form-label col-lg-3 col-sm-12">Document</label>
					<div class="col-lg-8 col-md-9 col-sm-12">
						<input class="form-control" type="text" disabled name="document" value="{{ $piece->type_piece() }}" >
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-form-label col-lg-3 col-sm-12">Date expiration</label>
					<div class=" col-lg-8 col-md-9 col-sm-12">
						<input class="form-control" type="date" name="date_expiration" value="{{ $piece->date_expiration }}" id="example-date-input">
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-form-label col-lg-3 col-sm-12">Extension</label>
					<div class=" col-lg-8 col-md-9 col-sm-12">
						<input class="form-control" type="text" name="extension" disabled value="{{ $piece->extension }}" >
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-form-label col-lg-3 col-sm-12">Commentaire</label>
					<div class="col-lg-8 col-md-9 col-sm-12">
						<textarea name="commentaire" id="commentaire" rows="5" class="form-control">{{ $piece->commentaire }}</textarea>
						@if($piece->statut == 'attente')
							<div style="margin-top:5px;">
								<button class="btn btn-default btn-sm" type="button" onclick="$('#commentaire').append('Pièce illisible ')">Pièce illisible</button>
								<button class="btn btn-default btn-sm" type="button" onclick="$('#commentaire').append('Pièce périmée ')">Pièce périmée</button>
								<button class="btn btn-default btn-sm" type="button" onclick="$('#commentaire').append('Autre motif ')">Autre motif</button>
								<button class="btn btn-default btn-sm" type="button" onclick="$('#commentaire').append('Mauvaise pièce ')">Mauvaise pièce</button>
							</div>
						@endif
					</div>
				</div>
			</div>
			<div class="card-footer d-flex justify-content-between">
				<div class="kt-form__actions">
					<div class="row">
						<div class="col-lg-12 ml-lg-auto">
							@if($piece->statut == 'attente')
								<button type="button" onclick="accepterPiece('valide');" class="btn btn-success"><i class="fa fa-check"></i> Valider</button>
								<button type="button" onclick="accepterPiece('refus');" class="btn btn-danger"><i class="fa fa-times"></i> Refuser</button>
							@else
								@if($piece->statut == 'valide')
									<i class="fa fa-check"></i> Validé le {{ date("d/m/Y", strtotime($piece->updated_at)) }} <br>
									
									@if($user->checkRights("rejuger_pieces"))
										<button type="button" onclick="accepterPiece('refus');" class="btn btn-danger"><i class="fa fa-times"></i> Refuser</button>
									@endif
								@endif
								
								@if($piece->statut == 'refus')
									<i class="fa fa-check"></i> Refusé le {{ date("d/m/Y", strtotime($piece->updated_at)) }} <br>
									
									@if($user->checkRights("rejuger_pieces"))
										<button type="button" onclick="accepterPiece('valide');" class="btn btn-success"><i class="fa fa-check"></i> Valider</button>
									@endif
								@endif
							@endif
						
							<a href="/chantier/pieces" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Retour</a>
							<a href="/chantier/piece/{{ $piece->id }}" class="btn btn-warning"><i class="fa fa-download"></i> Télécharger</a>
						</div>
					</div>
				</div>
			</div>
		</form>

		<!--end::Form-->
	</div>