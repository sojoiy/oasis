@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Fiche véhicule</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $entite->name }}</span>
		
		<a href="/vehicules" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-arrow-left"></i> Retour
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<!--begin::Modal-->
	@foreach ($pieces as $piece)
		<div class="modal fade" id="kt_modal_{{ $piece->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">{{ $piece->type_piece() }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<p>Visuel de la pièce.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						<button type="button" class="btn btn-primary">Télécharger</button>
						<button type="button" data-dismiss="modal" onclick="supprimerPiece({{ $piece->id }})" class="btn btn-danger">Supprimer</button>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	
	@foreach ($habilitations as $habilitation)
		<div class="modal fade" id="hab_modal_{{ $habilitation->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">{{ $habilitation->id }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						<button type="button" class="btn btn-primary">Valider</button>
						<button type="button" data-dismiss="modal" onclick="supprimerHabilitation({{ $habilitation->id }})" class="btn btn-danger">Supprimer</button>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	
	<!--end::Modal-->
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-6">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							{{ $entite->name }}
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/vehicule/change">
						<input type="hidden" name="id" value="{{ $entite->id }}" />
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Immatriculation : *</label>
									<input type="text" name="immatriculation" required class="form-control" value="{{ $entite->immatriculation }}" placeholder="AM198RS">
								</div>
								<div class="form-group">
									<label>Type de véhicule :</label>
									<select class="form-control" name="type_vehicule">
										<option value="camionnette">Camionnette < 3.5t</option>
										<option value="navette">Navette</option>
										<option value="pl">PL</option>
										<option value="vl">VL Commerciale 2pl</option>
									</select>
								</div>
								<div class="form-group">
									<label>Marque :</label>
									<input type="text" name="marque" required class="form-control" value="{{ $entite->marque }}" placeholder="Marque">
								</div>
								<div class="form-group">
									<label>Modèle :</label>
									<input type="text" name="modele" required class="form-control" value="{{ $entite->modele }}" placeholder="Modèle">
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
									{{ $entite->name }}
								</a>
							
								<ul role="group" class="jstree-children">
									<li role="treeitem" data-jstree="{ &quot;opened&quot; : true }" aria-selected="false" aria-level="2" aria-labelledby="les_pieces" aria-expanded="true" id="les_pieces" class="jstree-node  jstree-open">
										<i class="jstree-icon jstree-ocl" role="presentation"></i>
										<a class="jstree-anchor" href="#" tabindex="-1" id="les_pieces">
											<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
											Pièces
										</a>
									
										<ul role="group" class="jstree-children">
											@foreach ($pieces as $piece)
												@if ($piece->date_expiration < date('Y-m-d'))
													<li role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-id-card kt-font-danger &quot; }" aria-selected="false" aria-level="2" aria-labelledby="p_{{ $piece->id }}_anchor" id="p_{{ $piece->id }}" class="jstree-node  jstree-leaf">
												@else	
													<li role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-id-card kt-font-success &quot; }" aria-selected="false" aria-level="2" aria-labelledby="p_{{ $piece->id }}_anchor" id="p_{{ $piece->id }}" class="jstree-node  jstree-leaf">
												@endif
										
													<i class="jstree-icon jstree-ocl" role="presentation"></i>
													<a class="jstree-anchor" href="#" data-toggle="modal" data-target="#kt_modal_{{ $piece->id }}" tabindex="-1" id="p_{{ $piece->id }}_anchor">
												
														{{ $piece->type_piece() }} 
												
														@if ($piece->date_expiration)
															({{ date('d/m/y', strtotime($piece->date_expiration)) }})
														@endif
													</a>
												</li>
											@endforeach
										</ul>
									</li>
									
									<li role="treeitem" data-jstree="{ &quot;opened&quot; : true }" aria-selected="false" aria-level="2" aria-labelledby="habilitations" aria-expanded="true" id="habilitations" class="jstree-node  jstree-open">
										<i class="jstree-icon jstree-ocl" role="presentation"></i>
										<a class="jstree-anchor" href="#" tabindex="-1" id="habilitations">
											<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
											Habilitations
										</a>
										
										<ul role="group" class="jstree-children">
											@foreach ($habilitations as $habilitation)
												@if ($habilitation->date_expiration < date('Y-m-d'))
													<li role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-address-card kt-font-success &quot; }" aria-selected="false" aria-level="3" aria-labelledby="h_{{ $habilitation->id }}" aria-disabled="true" id="h_{{ $habilitation->id }}" class="jstree-node  jstree-leaf">
												@else	
													<li role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-address-card kt-font-success &quot; }" aria-selected="false" aria-level="3" aria-labelledby="h_{{ $habilitation->id }}" aria-disabled="true" id="h_{{ $habilitation->id }}" class="jstree-node  jstree-leaf">
												@endif
										
													<i class="jstree-icon jstree-ocl" role="presentation"></i>
													<a class="jstree-anchor" href="#" data-toggle="modal" data-target="#hab_modal_{{ $habilitation->id }}" tabindex="-1" id="h_{{ $habilitation->id }}_anchor">
												
														{{ $habilitation->type_piece }} 
												
														@if ($habilitation->date_expiration)
															({{ $habilitation->date_expiration }})
														@endif
													</a>
												</li>
											@endforeach
										</ul>
									</li>
									
									<li role="treeitem" data-jstree="{ &quot;opened&quot; : true }" aria-selected="false" aria-level="2" aria-labelledby="chantiers" aria-expanded="true" id="chantiers" class="jstree-node  jstree-open">
										<i class="jstree-icon jstree-ocl" role="presentation"></i>
										<a class="jstree-anchor" href="#" tabindex="-1" id="chantiers">
											<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
											Chantiers
										</a>
										
										<ul role="group" class="jstree-children">
											@foreach ($chantiers as $chantier)
											<li role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-tools kt-font-success &quot; }" aria-selected="false" aria-level="3" aria-labelledby="ch_{{ $chantier->id }}" aria-disabled="true" id="ch_{{ $chantier->id }}" class="jstree-node  jstree-leaf">
												<i class="jstree-icon jstree-ocl" role="presentation"></i>
												<a class="jstree-anchor" href="#" tabindex="-1" id="ch_{{ $chantier->id }}"><i class="jstree-icon jstree-themeicon fa fa-file  kt-font-default jstree-themeicon-custom" role="presentation"></i>
													{{ $chantier->numero }} ({{ $chantier->do() }})
												</a>
											</li>
											@endforeach
										</ul>
									</li>
								</ul>
							</li>
							<li role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-link kt-font-default &quot; }" aria-selected="false" aria-level="1" aria-labelledby="j2_8_anchor" id="j2_8" class="jstree-node  jstree-leaf jstree-last">
								<i class="jstree-icon jstree-ocl" role="presentation"></i>
								<a class="jstree-anchor" href="/intervenant/download/{{ $entite->id }}" tabindex="-1" id="j2_8_anchor">
									<i class="jstree-icon jstree-themeicon fa fa-link kt-font-default  jstree-themeicon-custom" role="presentation"></i>
									Télécharger l'archive
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--end::Widget 9-->
			<!--end:: Widgets/Download Files-->
			
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Charger une pièce
						</h3>
					</div>
				</div>

				<!--begin::Form-->
				<form class="kt-form kt-form--label-right" action="/vehicule/addpiece" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id" value="{{ $entite->id }}" />
					{{ csrf_field() }}
					<div class="card-body">
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Document</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<select name="type_piece" class="form-control selectpicker">
									@foreach($typesPieces as $typePiece)
										<option value="{{ $typePiece->id }}">{{ $typePiece->libelle }}</option>
									@endforeach
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Date expiration</label>
							<div class=" col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="date" name="date_expiration" value="" id="example-date-input">
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
	<script src="{{ asset('assets/js/intervenant.js') }}" type="text/javascript"></script>
@endsection