@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Mes entités</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		
		<a href="/entite/createnew" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
			<i class="fa fa-plus"></i> Ajout un élément
		</a>
		
		<a href="/entite/listertypes" class="btn btn-label-info btn-bold btn-sm btn-icon-h">
			<i class="fa fa-list"></i> Mes types d'entités
		</a>
		
		<form action="/search" method="post">
		{{ csrf_field() }}
		<div class="kt-input-icon kt-input-icon--right kt-subheader__search">
			<input type="text" name="keywords" class="form-control" placeholder="Rechercher..." id="generalSearch">
			<span class="kt-input-icon__icon kt-input-icon__icon--right">
				<span><i class="fa fa-search"></i></span>
			</span>
		</div>
		</form>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
								
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-12">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							{{ $user->nomSociete() }}
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#kt_widget4_tab1_content" role="tab">
									Actif
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#kt_widget4_tab2_content" role="tab">
									Supprimés
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								@foreach ($entites as $entite)
									<div class="kt-widget4__item" id="e_{{ $entite->id }}">
										<div class="kt-widget4__info">
												{{ $entite->name }}
											<a href="/entite/typeentite/{{ $entite->type_entite }}" class="kt-widget4__username">
												{{ $entite->nomType() }}
											</a>
										</div>
										<a href="/entite/showEntite/{{ $entite->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
										<button onclick="deleteEntite({{ $entite->id }})" class="btn btn-sm btn-danger btn-bold">Supprimer</button>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	</div>
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/entites.js') }}" type="text/javascript"></script>
@endsection
