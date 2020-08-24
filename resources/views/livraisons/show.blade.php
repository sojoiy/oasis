@extends('layout.default')

@section('content')

@include('livraisons.head', ['active' => 'Informations'])

<!-- begin:: Content -->
@include('livraisons.modal_prorogation', ['livraison' => $livraison])					
					
<div class="card card-custom">
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-4">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Livraison : {{ $livraison->numero }}
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<div class="form-group">
						<label>Type de dossier : {{ $livraison->type_livraison2($user->societe) }}</label><br>
						<label>Numéro : {{ $livraison->numero }}</label><br>
						<label>Date de début : {{ date('d/m/Y', strtotime($livraison->date_debut)) }}</label><br>
						<label>Date de fin : {{ date('d/m/Y', strtotime($livraison->date_fin)) }}</label>
					</div>
					<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
					@if($livraison->do == $user->societeID)
						<div class="form-group" id="info_cloture">
							<button type="button" onclick="cloturer({{ $livraison->id }})" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-times-circle"></i> Fermer ce dossier</button>
						</div>
					@endif
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
		
		<div class="col-md-8">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Mémo
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<div class="form-group">
						@if($livraison->do == $user->societeID)
							<textarea name="memo" id="memo" rows="5" onkeyup="$('#save_memo').show();" class="form-control">{{ $livraison->memo }}</textarea>
						@else
							<p>{{ $livraison->memo }}</p>
						@endif
						<br><button type="button" onclick="saveMemo({{ $livraison->id }})" id="save_memo" class="btn btn-info btn-sm" style="display:none;"><i class="fa fa-save"></i> Enregistrer</button>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Prestataires
						</h3>
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
									@foreach($transporteurs as $transporteur)
									
										<li role="treeitem" data-jstree="{ &quot;opened&quot; : true }" aria-selected="false" aria-level="2" aria-labelledby="j2_{{$transporteur->id}}_anchor" aria-expanded="true" id="j2_{{$transporteur->id}}" class="jstree-node  jstree-open">
											<i class="jstree-icon jstree-ocl" role="presentation"></i>
											<a onclick="showMandat({{$transporteur->id}})" class="jstree-anchor" href="#" tabindex="-1" id="j2_{{$transporteur->id}}_anchor">
												<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
												{{$transporteur->raisonSociale()}}
											</a>
											
											<ul role="group" class="jstree-children">
												@foreach($transporteur->mandats() as $mandat)
									
													<li role="treeitem" data-jstree="{ &quot;opened&quot; : true }" aria-selected="false" aria-level="2" aria-labelledby="j3_{{$mandat->id}}_anchor" aria-expanded="true" id="j3_{{$mandat->id}}" class="jstree-node  jstree-open">
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
	</div>

	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/livraison.js') }}" type="text/javascript"></script>
@endsection