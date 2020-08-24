@extends('layout.default')

<link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />

@section('content')

<!-- end:: Content Head -->
@include('chantier.modal_prorogation', ['chantier' => $chantier])

<!-- begin:: Content -->
<div class="row">
	<div class="col-md-8">
		<div class="card card-custom" id="viewer">
			<div class="card-header">
				<div class="card-title">
					<h3>Prestataires</h3>
				</div>
			</div>
			<div class="card-body">
				<div id="kt_tree_2" class="tree-demo jstree jstree-2 jstree-default" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j2_1" aria-busy="false">
					<ul class="jstree-container-ul jstree-children" role="group">
						<li role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j2_1_anchor" aria-expanded="true" id="j2_1" class="jstree-node  jstree-open">
							<i class="jstree-icon jstree-ocl" role="presentation"></i>
							<a class="jstree-anchor" href="#" tabindex="-1" id="j2_1_anchor">
								<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
								{{ $titulaire->raisonSociale }} (Principal)
							</a>
				
							<ul role="group" class="jstree-children">
								@foreach($titulaires as $titulaire)
					
									<li role="treeitem" data-jstree="{ &quot;opened&quot; : true }" aria-selected="false" aria-level="2" aria-labelledby="j2_{{$titulaire->id}}_anchor" aria-expanded="true" id="j2_{{$titulaire->id}}" class="jstree-node  jstree-open">
										<i class="jstree-icon jstree-ocl" role="presentation"></i>
										<a onclick="showMandat({{$titulaire->id}})" class="jstree-anchor" href="#" tabindex="-1" id="j2_{{$titulaire->id}}_anchor">
											<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
											{{$titulaire->raisonSociale()}}
										</a>
							
										<ul role="group" class="jstree-children">
											@foreach($titulaire->mandats() as $mandat)
					
												<li data-jstree='{ "icon" : "flaticon2-size text-success " }'>
													<i class="jstree-icon jstree-ocl" role="presentation"></i>
													<a onclick="showMandat({{ $mandat->id }})" class="jstree-anchor" href="#" tabindex="-1" id="j3_{{$mandat->id}}_anchor">
														<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
														{{ $mandat->getName() }}
													</a>
												</li>
											@endforeach
					
										</ul>
									</li>
								@endforeach
					
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card card-custom" id="viewer">
			<div class="card-header">
				<div class="card-title">
					<h3>Détails</h3>
				</div>
			</div>
			<div class="card-body" id="affichage">
			</div>
		</div>
	</div>
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js?v=7.0.5') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/pages/features/miscellaneous/treeview.js?v=7.0.5') }}" type="text/javascript"></script>
@endsection