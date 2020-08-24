<div class="modal fade" id="kt_modal_prorogation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">

		<form class="kt-form" method="POST" id="prorogation" action="/livraison/proroger">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Proroger le livraison</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
					<input type="hidden" name="livraisonID" value="{{ $livraison->id }}" />
					{{ csrf_field() }}
					<div class="form-group row">
						<label class="col-form-label col-lg-3 col-sm-12">Date actuelle</label>
						<div class=" col-lg-8 col-md-9 col-sm-12">
							<input class="form-control" type="date" name="ancienne_date" disabled value="{{ date('Y-m-d', strtotime($livraison->date_fin)) }}" id="example-date-input">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-form-label col-lg-3 col-sm-12">Nouvelle date</label>
						<div class=" col-lg-8 col-md-9 col-sm-12">
							<input class="form-control" type="date" name="date_fin" value="" id="example-date-input">
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="proroger()" data-dismiss="modal" class="btn btn-primary">Confirmer</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">Annuler</button>
				<!-- ><button type="button" data-dismiss="modal" class="btn btn-danger">Non merci, je veux recharger mes pièces</button> -->
			</div>
		</div>
		</form>
	</div>
</div>