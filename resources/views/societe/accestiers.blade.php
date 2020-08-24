				<div class="card-header">
					<div class="card-title">
						<h3>
							Mes accès tiers
						</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="text-center">Contact</th>
									<th class="text-center">Email</th>
									<th class="text-center">Expiration</th>
									<th class="text-center"></th>
								</tr>
							</thead>
							<tbody id="actions_chantier">
								@foreach ($liens as $lien)
									<tr id="lien_{{ $lien->id }}">
										<td class="text-center" style="width:35%;">{{ $lien->contact }}</td>
										<td class="text-center" style="width:35%;" nowrap>{{ $lien->login }}</td>
										<td class="text-center" style="width:20%;">{{ date("d/m/Y", strtotime($lien->date_expiration)) }}</td>
										<td class="text-center" id="result_{{ $lien->id }}" style="width:30px;" nowrap>
											<button class="btn btn-sm text-success" type="button" onclick="sendLink({{ $lien->id }})">
												<i class="fa fa-2x fa-envelope"></i>
											</button>
											<button class="btn btn-sm text-danger" type="button" onclick="deleteLink({{ $lien->id }})">
												<i class="fa fa-2x fa-trash"></i>
											</button>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					
					<!--begin::Form-->
					<!-- <form class="kt-form kt-form--label-right" id="creer-acces" method="POST">
						<input type="hidden" name="id" value="{{ $societe->id }}" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="form-group row">
								<label class="col-form-label col-lg-3 col-sm-12">Périmètre</label>
								<div class="col-lg-8 col-md-9 col-sm-12">
									<select name="chantier" class="form-control selectpicker">
											<option value="documents">Documents</option>
									</select>
								</div>
							</div>
						
							<div class="form-group row">
								<label class="col-form-label col-lg-3 col-sm-12">Date expiration</label>
								<div class=" col-lg-8 col-md-9 col-sm-12">
									<input class="form-control" type="date" name="date_expiration" value="{{ date('Y-m-d') }}" id="example-date-input">
								</div>
							</div>
						
							<div class="form-group row">
								<label class="col-form-label col-lg-3 col-sm-12">Email *</label>
								<div class=" col-lg-8 col-md-9 col-sm-12">
									<input type="email" required name="email" value="" required class="form-control" placeholder="Email">
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-form-label col-lg-3 col-sm-12">Contact *</label>
								<div class=" col-lg-8 col-md-9 col-sm-12">
									<input type="text" required name="contact" value="" required class="form-control" placeholder="Nom du contact">
								</div>
							</div>
						</div>
						<div class="card-footer d-flex justify-content-between">
							<div class="kt-form__actions">
								<div class="row">
									<div class="col-lg-9 ml-lg-auto">
										<button type="submit" class="btn btn-brand">Créer</button>
										<button type="reset" class="btn btn-secondary">Annuler</button>
									</div>
								</div>
							</div>
						</div>
					</form> -->
				</div>