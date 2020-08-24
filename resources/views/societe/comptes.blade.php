@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
@include('societe.head', ['active' => 'Utilisateurs'])

<!-- end:: Content Head -->

<!-- begin:: Content -->
<div class="card card-custom">
								
	<!--Begin::Section-->
	<div class="row">
		<div class="col-xl-12">

			<!--begin:: Widgets/New Users-->
			<div class="card card-custom">
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane active" id="kt_widget4_tab1_content">
							<div class="kt-widget4">
								@foreach ($comptes as $compte)
									<div id="c_{{ $compte->id }}" class="kt-widget4__item">
										<div class="kt-widget4__pic kt-widget4__pic--pic">
											<img src="assets/media/users/100_4.jpg" alt="">
										</div>
										<div class="kt-widget4__info">
											<a href="#" class="kt-widget4__username">
												{{ $compte->name }}
											</a>
											<p class="kt-widget4__text">
												{{ $compte->email }}
											</p>
										</div>
										<a href="/societe/compte/{{ $compte->id }}" class="btn btn-sm btn-label-brand btn-bold">Voir</a>&nbsp;
										<button onclick="deleteCompte({{ $compte->id }})" class="btn btn-sm btn-danger btn-bold">Supprimer</button>
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
	<script src="{{ asset('assets/js/societe.js') }}" type="text/javascript"></script>
@endsection
