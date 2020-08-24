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
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
					<button type="button" class="btn btn-primary">Save changes</button>
					<button type="button" data-dismiss="modal" onclick="supprimerPiece({{ $piece->id }})" class="btn btn-danger">Supprimer</button>
				</div>
			</div>
		</div>
	</div>
@endforeach

<div class="card-header">
	<div class="card-title">
		<h3>
			Activité
		</h3>
	</div>
</div>
<div class="card-body">
	@if($message != "EMPTY" && $message != "ITEM_ADDED")
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
	
	@if($message == "ITEM_ADDED")
		<div class="alert alert-success fade show" role="alert">
			<div class="alert-icon"><i class="fa fa-check"></i></div>
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
											({{ $piece->date_expiration }})
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
							<li role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-tools kt-font-success &quot; }" aria-selected="false" aria-level="3" aria-labelledby="ch_0" aria-disabled="true" id="ch_0" class="jstree-node  jstree-leaf">
								<i class="jstree-icon jstree-ocl" role="presentation"></i>
								
								<a class="jstree-anchor" href="#" tabindex="-1" id="ch_0"><i class="jstree-icon jstree-themeicon fa fa-file  kt-font-default jstree-themeicon-custom" role="presentation"></i>
									42001789038 (EDF)
								</a>
							</li>
							<li role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-tools kt-font-success &quot; }" aria-selected="false" aria-level="3" aria-labelledby="ch_1" id="ch_1" class="jstree-node  jstree-leaf jstree-last">
								<i class="jstree-icon jstree-ocl" role="presentation"></i>
								<a class="jstree-anchor" href="#" tabindex="-1" id="ch_1"><i class="jstree-icon jstree-themeicon fa fa-file  kt-font-default jstree-themeicon-custom" role="presentation"></i>
									42001789038 (VEOLIA)
								</a>
							</li>
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

<script src="{{ asset('assets/vendors/custom/jstree/jstree.bundle.js') }}" type="text/j[avascript"></script>
<script src="{{ asset('assets/js/demo1/pages/components/extended/treeview.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/intervenant.js') }}" type="text/javascript"></script>