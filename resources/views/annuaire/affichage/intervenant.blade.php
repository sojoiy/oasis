@extends('layout.default')

<link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />

@section('content')
<!-- begin:: Content Head -->

<!-- end:: Content Head -->

<!-- begin:: Content -->

	<div class="row">
		<div class="col-md-4">

			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
					</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Nom : {{ $entite->nom }}</label>
					</div>
					<div class="form-group">
						<label>Prénom : {{ $entite->prenom }}</label>
					</div>
					<div class="form-group">
						<label>Fonction : {{ $entite->fonction }}</label>
					</div>
					<div class="form-group">
						<label>Date de naissance :</label>
					</div>
				</div>
			</div>
			
			<br>
			
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
					</div>
				</div>
				<div class="card-body">
					
				</div>
			</div>
			
			<!--begin:: Widgets/Download Files-->
			@if($user->checkRights("visualiser_pieces"))
			<br>
				<div class="card card-custom">
					<div class="card-header">
						<div class="card-title">
							<h3>Documents</h3>
						</div>
					</div>
					<div class="card-body">
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
												@foreach ($copies as $piece)
													@if ($piece->statut == "valide")
														<li data-jstree='{ "icon" : "flaticon2-check-mark text-success" }'>
													@elseif($piece->date_expiration < date('Y-m-d') || $piece->statut == "refus")
														<li data-jstree='{ "icon" : "flaticon-exclamation-1 text-danger" }'>
													@else
														<li data-jstree='{ "icon" : "flaticon2-hourglass-1 text-warning" }'>
													@endif
										
														<a class="jstree-anchor" href="#" onclick="afficherDocument({{ $piece->id }});" tabindex="-1" id="p_{{ $piece->id }}_anchor">
												
															{{ $piece->abbr() }}
															-
															{{ ucfirst($piece->statut) }} 
												
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
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			@endif
			<!--end::Widget 9-->
			<!--end:: Widgets/Download Files-->
			
		</div>
		
		@if($user->checkRights("visualiser_pieces"))
			<div class="col-md-8">
				
				<div class="card card-custom" id="viewer">
					<div class="card-header">
						<div class="card-title">
						</div>
					</div>
					<div class="card-body">
						<iframe src = "/temp/ViewerJS/#../test_de.pdf" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
					</div>
				</div>
			</div>
		@endif
	</div>
	
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js?v=7.0.5') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/pages/features/miscellaneous/treeview.js?v=7.0.5') }}" type="text/javascript"></script>
@endsection