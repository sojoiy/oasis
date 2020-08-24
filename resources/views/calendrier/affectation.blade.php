@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Horaires</h3>
		<span class="kt-subheader__separator kt-subheader__separator--v"></span>
		<a href="/calendrier/newtype" class="btn btn-label-info btn-bold btn-sm btn-icon-h kt-margin-l-10">
			<i class="fa fa-user"></i> Créer une semaine type
		</a>
	</div>
	<div class="kt-subheader__toolbar">
		
	</div>
</div>

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
								
	<!--Begin::Section-->
	<form method="post" action="/calendrier/affecter_semaines">
	{{ csrf_field() }}
	<div class="row">
		<div class="col-xl-6 col-md-6">
			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Affectations
						</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								@foreach ($semaines as $semaine)
									<div class="kt-widget4__item">
										<div class="kt-widget4__info">
											<a href="/comptes/creneau/{{ $semaine->id }}" class="kt-widget4__username">
												Semaine {{ $semaine->numero }} du <b>{{ date("d/m/Y", strtotime($semaine->date_debut)) }}</b> au <b>{{ date("d/m/Y", strtotime($semaine->date_fin)) }}</b>
											</a>
										</div>
									
										<div class="kt-widget4__info">
											<div class="row">
												<i class="fa fa-info-circle" data-container="body" data-toggle="kt-popover" data-placement="bottom" data-content="{{ $societe->getNomTypeSemaine($semaine->id) }}"></i>&nbsp;
												<i class="fa fa-redo" onclick="recreerCreneaux({{ $semaine->id }})"></i>&nbsp;
												<label class="kt-checkbox">
													<input type="checkbox" name="semaines[]" value="{{ $semaine->id }}" >
													<span></span>
												</label>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--end:: Widgets/New Users-->
		</div>
	
		<div class="col-xl-6 col-md-6">
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<h3>
							Choisissez un type de semaine
						</h3>
					</div>
				</div>
				<div class="card-body">
					@foreach($typeSemaines as $typeSemaine)
						<div class="kt-radio-inline">
							<label class="kt-radio kt-radio--solid">
								<input type="radio" value="{{ $typeSemaine->id }}" name="type_semaine"> {{ $typeSemaine->libelle }}
								<span></span>
							</label>
							<a href="/calendrier/modifierTypeSemaines/{{ $typeSemaine->id }}"> (<i class="fa fa-edit"></i> Modifier)</a>
						</div>
					@endforeach
				</div>
			</div>
			<button type="submit" style="width:100%;" class="btn btn-success">Affecter les semaines sélectionnées</button>
		</div>	
	</div>
	</form>
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/calendrier.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/input-mask.js') }}" type="text/javascript"></script>
@endsection