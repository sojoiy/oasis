@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">{{ $chantier->numero }}</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		
		<a href="/chantier/sent" class="btn btn-label-brand btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-user-tie"></i> DO : {{ $chantier->do() }}</a>
		
		<a href="/chantier/show/{{$chantier->id}}" class="btn btn-label-primary btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-info"></i> Informations
		</a>
		
		<a href="/chantier/intervenants/{{$chantier->id}}" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-user-friends"></i> Intervenants
		</a>
		<a href="/chantier/vehicules/{{$chantier->id}}" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-truck"></i> Véhicules
		</a>
		
		<a href="/chantier/choixpresta/{{$chantier->id}}" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-plus"></i> Gérer les titulaires
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
					
					
<div class="card card-custom">
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-4">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Chantier : {{ $chantier->numero }}
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<div class="form-group">
						<label>Type de dossier : {{ $chantier->type_chantier() }}</label><br>
						<label>Numéro : {{ $chantier->numero }}</label><br>
						<label>Date de début : {{ date('d/m/Y', strtotime($chantier->date_debut)) }}</label><br>
						<label>Date de fin : {{ date('d/m/Y', strtotime($chantier->date_fin)) }}</label>
					</div>
					<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
					<div class="form-group" id="info_cloture">
						<button type="button" onclick="cloturer({{ $chantier->id }})" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-times-circle"></i> Fermer ce chantier</button>
					</div>
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
						@if($chantier->do == $user->societeID)
							<textarea name="memo" id="memo" rows="5" onkeyup="$('#save_memo').show();" class="form-control">{{ $chantier->memo }}</textarea>
						@else
							<p>{{ $chantier->memo }}</p>
						@endif
						<br><button type="button" onclick="saveMemo({{ $chantier->id }})" id="save_memo" class="btn btn-info btn-sm" style="display:none;"><i class="fa fa-save"></i> Enregistrer</button>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="kt-portlet kt-portlet--height-fluid" id="affichage">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Activité
						</h3>
					</div>
				</div>
				<div class="card-body">

					<!--Begin::Timeline 3 -->
					<div class="kt-timeline-v2">
						<div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
							@foreach($evenements as $event)
								<div class="kt-timeline-v2__item">
									<span class="kt-timeline-v2__item-time">{{ date('d/m', strtotime($event->created_at)) }}</span>
									<div class="kt-timeline-v2__item-cricle">
										<i class="fa fa-genderless kt-font-danger"></i>
									</div>
									<div class="kt-timeline-v2__item-text  kt-padding-top-5">
										{{ $event->description }}
									</div>
								</div>
							@endforeach
						</div>
					</div>

					<!--End::Timeline 3 -->
				</div>
			</div>
		</div>
		
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
									@foreach($titulaires as $titulaire)
									
										<li role="treeitem" data-jstree="{ &quot;opened&quot; : true }" aria-selected="false" aria-level="2" aria-labelledby="j2_{{$titulaire->id}}_anchor" aria-expanded="true" id="j2_{{$titulaire->id}}" class="jstree-node  jstree-open">
											<i class="jstree-icon jstree-ocl" role="presentation"></i>
											<a onclick="showMandat({{$titulaire->id}})" class="jstree-anchor" href="#" tabindex="-1" id="j2_{{$titulaire->id}}_anchor">
												<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
												{{$titulaire->raisonSociale()}}
											</a>
											
											<ul role="group" class="jstree-children">
												@foreach($titulaire->mandats() as $mandat)
									
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
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection