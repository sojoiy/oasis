@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Création d'un type de semaine</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/calendrier/affectation" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
			<i class="fa fa-arrow-left"></i> Retour
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
		<div class="col-xl-12 col-md-12">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							<input type="text" name="libelle" value="{{ $typeSemaine->libelle }}" onchange="changerNomTypeSemaine(this.value, {{ $typeSemaine->id }})" class="form-control" placeholder="Libellé" />
						</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<table class="table table-striped table-bordered table-hover table-checkable">
							<thead>
								<tr>
									<th>Lundi</th>
									<th>Mardi</th>
									<th>Mercredi</th>
									<th>Jeudi</th>
									<th>Vendredi</th>
									<th>Samedi</th>
									<th>Dimanche</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td id="Lundi"></td>
									<td id="Mardi"></td>
									<td id="Mercredi"></td>
									<td id="Jeudi"></td>
									<td id="Vendredi"></td>
									<td id="Samedi"></td>
									<td id="Dimanche"></td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th>
										<form id="ajoutLundi" method="post" action="/calenrier/savetype">
											<input type="hidden" name="jour" value="lundi" />
											<input type="hidden" name="id" value="{{ $typeSemaine->id }}" />
											{{ csrf_field() }}
											<input type="time" name="heure_debut" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="time" name="heure_fin" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="number" name="places" class="form-control" placeholder="" >
											<button type="submit" style="width:100%;" class="btn btn-success">Ajouter</button>
										</form>
									</th>
									<th>
										<form id="ajoutMardi" method="post" action="/calenrier/savetype">
											<input type="hidden" name="jour" value="mardi" />
											<input type="hidden" name="id" value="{{ $typeSemaine->id }}" />
											{{ csrf_field() }}
											<input type="time" name="heure_debut" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="time" name="heure_fin" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="number" name="places" class="form-control" placeholder="" >
											<button type="submit" style="width:100%;" class="btn btn-success">Ajouter</button>
										</form>
									</th>
									<th>
										<form id="ajoutMercredi" method="post" action="/calenrier/savetype">
											<input type="hidden" name="jour" value="mercredi" />
											<input type="hidden" name="id" value="{{ $typeSemaine->id }}" />
											{{ csrf_field() }}
											<input type="time" name="heure_debut" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="time" name="heure_fin" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="number" name="places" class="form-control" placeholder="" >
											<button type="submit" style="width:100%;" class="btn btn-success">Ajouter</button>
										</form>
									</th>
									<th>
										<form id="ajoutJeudi" method="post" action="/calenrier/savetype">
											<input type="hidden" name="jour" value="jeudi" />
											<input type="hidden" name="id" value="{{ $typeSemaine->id }}" />
											{{ csrf_field() }}
											<input type="time" name="heure_debut" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="time" name="heure_fin" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="number" name="places" class="form-control" placeholder="" >
											<button type="submit" style="width:100%;" class="btn btn-success">Ajouter</button>
										</form>
									</th>
									<th>
										<form id="ajoutVendredi" method="post" action="/calenrier/savetype">
											<input type="hidden" name="jour" value="vendredi" />
											<input type="hidden" name="id" value="{{ $typeSemaine->id }}" />
											{{ csrf_field() }}
											<input type="time" name="heure_debut" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="time" name="heure_fin" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="number" name="places" class="form-control" placeholder="" >
											<button type="submit" style="width:100%;" class="btn btn-success">Ajouter</button>
										</form>
									</th>
									<th>
										<form id="ajoutSamedi" method="post" action="/calenrier/savetype">
											<input type="hidden" name="jour" value="samedi" />
											<input type="hidden" name="id" value="{{ $typeSemaine->id }}" />
											{{ csrf_field() }}
											<input type="time" name="heure_debut" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="time" name="heure_fin" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="number" name="places" class="form-control" placeholder="" >
											<button type="submit" style="width:100%;" class="btn btn-success">Ajouter</button>
										</form>
									</th>
									<th>
										<form id="ajoutDimanche" method="post" action="/calenrier/savetype">
											<input type="hidden" name="jour" value="dimanche" />
											<input type="hidden" name="id" value="{{ $typeSemaine->id }}" />
											{{ csrf_field() }}
											<input type="time" name="heure_debut" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="time" name="heure_fin" class="form-control sjy_inputmask_hour" placeholder="" id="sjy_inputmask_hour" >
											<input type="number" name="places" class="form-control" placeholder="" >
											<button type="submit" style="width:100%;" class="btn btn-success">Ajouter</button>
										</form>
									</th>
								</tr>
							</tfoot>
						</table>
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
	<script src="{{ asset('assets/js/calendrier.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/input-mask.js') }}" type="text/javascript"></script>
@endsection