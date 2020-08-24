@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
@include('societe.head', ['active' => 'Documents'])

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="modal fade" id="kt_modal_createlink" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Créer une action</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form class="kt-form" id="creer-acces" method="POST" action="/societe/ajouteracces">
				<input type="hidden" name="id" value="{{ $user->societeID }}" />
				<div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Contact : *</label>
						<input type="text" name="contact" required class="form-control" placeholder="Contact">
					</div>
					<div class="form-group">
						<label>Email :</label>
						<input type="text" name="email" required class="form-control" placeholder="Email">
					</div>
					<div class="form-group">
						<label>Date limite :</label>
						<input class="form-control" type="date" name="date_expiration" value="" id="example-date-input">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Valider</button>
					<button type="reset" class="btn btn-secondary">Annuler</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="card card-custom">
	<!--begin::Modal-->
	@foreach ($documents as $document)
		<div class="modal fade" id="kt_modal_{{ $document->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">{{ $document->nom }} ( {{ ucfirst($document->type_piece) }})</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<p>{{ $document->description }}</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						<a href="/societe/getDocument/{{ $document->id }}" class="btn btn-primary">Télécharger</a>
						<button type="button" data-dismiss="modal" onclick="supprimerDocument({{ $document->id }})" class="btn btn-danger">Supprimer</button>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	
	<!--end::Modal-->
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-6">
			<!--begin:: Widgets/Download Files-->
			<div class="kt-portlet" id="activite">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Documents
						</h3>
					</div>
				</div>
				<div class="card-body">
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
																		
					<div id="kt_tree_2" class="tree-demo jstree jstree-2 jstree-default" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j2_6" aria-busy="false">
						<ul class="jstree-container-ul jstree-children" role="group">
							<li role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j2_0_anchor" aria-expanded="true" id="j2_0" class="jstree-node jstree-open">
								<i class="jstree-icon jstree-ocl" role="presentation"></i>
								<a class="jstree-anchor" href="#" tabindex="-1" id="j2_1_anchor">
									<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
									{{ $societe->raisonSociale }}
								</a>
							
								<ul role="group" class="jstree-children">
									<li role="treeitem" data-jstree="{ &quot;opened&quot; : true }" aria-selected="false" aria-level="2" aria-labelledby="les_pieces" aria-expanded="true" id="les_pieces" class="jstree-node  jstree-open">
										<i class="jstree-icon jstree-ocl" role="presentation"></i>
										<a class="jstree-anchor" href="#" tabindex="-1" id="les_pieces">
											<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
											Documents
										</a>
									
										<ul role="group" class="jstree-children">
											@foreach ($documents as $document)
												@if ($document->date_expiration < date('Y-m-d'))
													<li  onclick="visualiserDocument({{ $document->id }})" role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-id-card kt-font-danger &quot; }" aria-selected="false" aria-level="2" aria-labelledby="p_{{ $document->id }}_anchor" id="p_{{ $document->id }}" class="jstree-node  jstree-leaf">
												@else	
													<li  onclick="visualiserDocument({{ $document->id }})" role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-id-card kt-font-success &quot; }" aria-selected="false" aria-level="2" aria-labelledby="p_{{ $document->id }}_anchor" id="p_{{ $document->id }}" class="jstree-node  jstree-leaf">
												@endif
						
													<i class="jstree-icon jstree-ocl" role="presentation"></i>
													<a class="jstree-anchor" href="#" tabindex="-1" id="p_{{ $document->id }}_anchor">
								
														{{ $document->type_piece }} 
								
														@if ($document->date_expiration)
															({{ date("d/m/Y", strtotime($document->date_expiration)) }})
														@endif
													</a>
												</li>
											@endforeach
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="kt-portlet" id="acces_tiers">
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
			</div>
		</div>
		<div class="col-md-6">
			<!--begin:: Widgets/New Users-->
			<div class="kt-portlet" id="viewer">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Visualisation
						</h3>
					</div>
				</div>
				<div class="card-body">
					<iframe src = "/temp/ViewerJS/#../test_de.pdf" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
				</div>
				<!--end::Form-->
			</div>
			
			<div class="kt-portlet" style="display:none;" id="add_document">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Ajouter un document
						</h3>
					</div>
				</div>

				<!--begin::Form-->
				<form class="kt-form kt-form--label-right" action="/societe/chargerdocument" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id" value="{{ $societe->id }}" />
					{{ csrf_field() }}
					<div class="card-body">
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Document</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<select name="type_piece" class="form-control selectpicker">
									<optgroup label="Jurdique annuel" data-max-options="2">
										<option value="attestation_urssaf">Attestation URSSAF</option>
									</optgroup>
									<optgroup label="Juridique permanent" data-max-options="2">
										<option value="kbis">KBis</option>
										<option  value="statuts">Statuts</option>
									</optgroup>
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Nom</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="text" name="nom" value="" id="example-date-input">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Date expiration</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="date" name="date_expiration" value="{{ date('Y-m-d') }}" id="example-date-input">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Votre fichier</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="file" name="fichier" value="">
							</div>
						</div>
					</div>
					<div class="card-footer d-flex justify-content-between">
						<div class="kt-form__actions">
							<div class="row">
								<div class="col-lg-9 ml-lg-auto">
									<button type="submit" class="btn btn-brand">Valider</button>
									<button type="reset" class="btn btn-secondary">Annuler</button>
								</div>
							</div>
						</div>
					</div>
				</form>

				<!--end::Form-->
			</div>
		</div>	
	</div>
	
	
	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/societe.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/dropzone-societe.js') }}" type="text/javascript"></script> 
@endsection