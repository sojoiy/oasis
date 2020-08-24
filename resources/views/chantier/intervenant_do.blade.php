@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Fiche intervenant</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<span class="kt-subheader__desc">{{ $user->nomSociete() }}</span>
		
		<a href="/chantier/materielDo/{{$chantier->id}}" class="btn btn-label-primary btn-bold btn-sm btn-icon-h kt-margin-l-5">
			<i class="fa fa-arrow-left"></i> Retour
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
	<div class="row">
		<div class="col-md-4">
			<div class="kt-portlet">
				<div class="card-body">
					<!--begin::Form-->
					<div class="card-body">
						<div class="kt-section kt-section--first">
							@foreach($lesChamps as $key => $unChamp)
								<div class="form-group">
									<label> {{ $unChamp->name }} : {{ $entite->getChamp($key) }}</label>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="kt-portlet">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Charger un document
						</h3>
					</div>
				</div>

				<!--begin::Form-->
				<form class="kt-form kt-form--label-right" action="/chantier/chargerdocument" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id" value="{{ $materiel->id }}" />
					<input type="hidden" name="chantier" value="{{ $chantier->id }}" />
					<input type="hidden" name="entite" value="{{ $materiel->intervenant }}" />
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
							<label class="col-form-label col-lg-3 col-sm-12">Votre fichier</label>
							<div class="col-lg-8 col-md-9 col-sm-12">
								<input class="form-control" type="file" name="document" value="">
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
					<div id="kt_tree_2" class="tree-demo jstree jstree-2 jstree-default" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j2_6" aria-busy="false">
						<ul class="jstree-container-ul jstree-children" role="group">
							<li role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j2_0_anchor" aria-expanded="true" id="j2_0" class="jstree-node jstree-open">
								<i class="jstree-icon jstree-ocl" role="presentation"></i>
								<a class="jstree-anchor" href="#" tabindex="-1" id="j2_1_anchor">
									<i class="jstree-icon jstree-themeicon fa fa-folder kt-font-warning jstree-themeicon-custom" role="presentation"></i>
									{{ $entite->name }}
								</a>
							
								<ul role="group" class="jstree-children">
									@foreach ($copies as $piece)
										@if ($piece->date_expiration < date('Y-m-d'))
											<li role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-id-card kt-font-danger &quot; }" aria-selected="false" aria-level="2" aria-labelledby="p_{{ $piece->id }}_anchor" id="p_{{ $piece->id }}" class="jstree-node  jstree-leaf">
										@else	
											<li role="treeitem" data-jstree="{ &quot;icon&quot; : &quot;fa fa-id-card kt-font-success &quot; }" aria-selected="false" aria-level="2" aria-labelledby="p_{{ $piece->id }}_anchor" id="p_{{ $piece->id }}" class="jstree-node  jstree-leaf">
										@endif
								
											<i class="jstree-icon jstree-ocl" role="presentation"></i>
											<a class="jstree-anchor" href="#" onclick="afficherDocument({{ $piece->id }});" tabindex="-1" id="p_{{ $piece->id }}_anchor">
										
												{{ $piece->type_piece() }} 
										
												@if ($piece->date_expiration)
													({{ date('d/m/y', strtotime($piece->date_expiration)) }})
												@endif
											</a>
										</li>
									@endforeach
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--end::Widget 9-->
			<!--end:: Widgets/Download Files-->
			
		</div>
		
		<div class="col-md-8">
			<!--begin:: Widgets/New Users-->
			<div class="kt-portlet" id="viewer">
				<div class="card-body">
					<iframe src = "/temp/ViewerJS/#../test_de.pdf" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
				</div>
				<!--end::Form-->
			</div>
			<!--end:: Widgets/New Users-->
		</div>
	</div>
	<!--End::Section-->
</div>
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/chantier.js') }}" type="text/javascript"></script>
@endsection