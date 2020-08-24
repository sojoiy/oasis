<!--begin::widget 12-->
<div class="kt-widget4">
	<div class="alert alert-light alert-elevate fade show" role="alert">
		<div class="alert-icon"><i class="fa fa-exclamation kt-font-warning"></i></div>
		<div class="alert-text">
			Si votre prestataire n'apparait pas dans la liste ci-dessous veuillez compléter et valider le formulaire de gauche.<br>
		</div>
	</div>
	
	@foreach ($prestataires as $prestataire)
		<div class="kt-widget4__item">
			<a href="#" class="kt-widget4__title kt-widget4__title--light">
				{{ $prestataire->raisonSociale }}
			</a>
			<span class="kt-widget4__number kt-font-info">{{ $prestataire->noSiret }}</span>
			
			<button type="button" onclick="choosePresta({{ $prestataire->id }})" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-hand-pointer"></i>
			</button>
		</div>
	@endforeach
</div>

	

<!--end::Widget 12-->