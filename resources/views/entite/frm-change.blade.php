@extends('layout.default')

@section('content')

<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Mes Ressources</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		
		<form action="/entite/listertypes" method="post">
		{{ csrf_field() }}
		<div class="kt-input-icon kt-input-icon--right kt-subheader__search">
			<input type="text" name="keywords" class="form-control" value="{{ (isset($keywords)) ? $keywords : '' }}" placeholder="Rechercher..." id="generalSearch">
			<span class="kt-input-icon__icon kt-input-icon__icon--right">
				<span><i class="fa fa-search"></i></span>
			</span>
		</div>
		</form>
		
		<a href="/entite/autres" class="btn btn-label-info active btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-arrow-left"></i> Retour
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	@include('alert.message', ['message' => $message])
	
	<!--begin::Modal-->
	
	<!--end::Modal-->
	
	<!--Begin::Section-->
	<div class="row">
		<div class="col-md-6">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							{{ $entite->nomType() }}
						</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Form-->
					<form class="kt-form" method="POST" action="/entite/saveentite">
						<input type="hidden" name="id" value="{{ $entite->id }}">
						{{ csrf_field() }}
						<div class="card-body">
							<div class="kt-section kt-section--first">
								<div class="form-group">
									<label>Identifiant : *</label>
									<input type="text" name="name" required class="form-control" value="{{ $entite->name }}" placeholder="Identifiant">
								</div>
								
								@foreach($lesChamps as $key => $unChamp)
								@if($unChamp->name != "")<div class="form-group">
									<label> {{ $unChamp->name }} :</label>
									@switch($unChamp->type)
									    @case("texte")
											<input type="text" name="{{ $key }}" value="{{ $entite->getChamp($key) }}" class="form-control" placeholder="">
											@break 
										@case("email")
											<input type="email" name="{{ $key }}" value="{{ $entite->getChamp($key) }}" class="form-control" placeholder="contact@example.com">
											@break
									    @case("date")
											<input type="date" name="{{ $key }}" value="{{ $entite->getChamp($key) }}" class="form-control" placeholder="" id="example-date-input">
											@break
									@endswitch	
								</div>
								@endif
								@endforeach
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
													<a class="jstree-anchor" href="#" onclick="afficherPiece({{ $piece->id }})" tabindex="-1" id="p_{{ $piece->id }}_anchor">
												
														{{ $piece->type_piece() }} 
												
														@if ($piece->date_expiration)
															({{ date('d/m/y', strtotime($piece->date_expiration)) }})
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
				<form class="kt-form kt-form--label-right" id="charger-piece" action="/entite/addpiece2" method="POST" enctype="multipart/form-data">
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
								<input class="form-control" type="date" name="date_expiration" value="{{ date('Y-m-d') }}" id="example-date-input">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-form-label col-lg-3 col-sm-12">Votre fichier</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="file" accept="image/png, image/jpeg, application/pdf" name="piece" value="" >
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
	
	<div class="row">
		<div class="col-md-8">
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
			</div>
		</div>
	</div>
	
	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/entite.js') }}" type="text/javascript"></script>
@endsection