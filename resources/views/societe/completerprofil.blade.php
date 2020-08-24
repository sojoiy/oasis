@extends('layout.default')

@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-subheader__main">
		<h3 class="kt-subheader__title">Configuration</h3>
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
			<div class="card card-custom">
				<div class="card-body">
					<div class="kt-section kt-section--first">
						<h4>Chantiers</h4>
						<div class="kt-section__content kt-section__content--solid">
							<div class="row">
								<div class="col-md-12">
									<h5 class="{{ $type_chantier_good == 0 ? 'text-danger' : 'text-success' }}">Types de chantiers : {{ $type_chantier_good }}/6 <a href="/comptes/validation"><i class="fa fa-cogs"></i></a></h5>
									<h5 class="text-default">Activation des rendez-vous : {{ $societe->rdv_active == 1 ? 'Oui' : 'Non' }} <a href="/comptes/configuration"><i class="fa fa-cogs"></i></a></h5>
									<h5 class="{{ $type_livraisons_good == 0 ? 'text-danger' : 'text-success' }}">Types de livraisons : {{ $type_livraisons_good }}/6 <a href="/comptes/livraison"><i class="fa fa-cogs"></i></a></h5>
								</div>
							</div>
						</div>
						<br><h4>Utilisateurs et groupes</h4>
						<div class="kt-section__content kt-section__content--solid">
							<div class="row">
								<div class="col-md-12">
									<h5 class="{{ $nombre_groupes == 0 ? 'text-danger' : 'text-success' }}">Groupes d'utilisateurs (minimum 2) : {{ $nombre_groupes }}/2 <a href="/comptes/profils"><i class="fa fa-cogs"></i></a></h5>
									<h5 class="{{ $comptes_acc == 0 ? 'text-danger' : 'text-success' }}">Compte d'accueil (minimum 1) : {{ $comptes_acc }}/1 <a href="/comptes"><i class="fa fa-cogs"></i></a></h5>
									<h5 class="{{ $comptes_vg == 0 ? 'text-danger' : 'text-success' }}">Compte de validation globale (minimum 1, si VG activée) : {{ $comptes_vg }}/1 <a href="/comptes"><i class="fa fa-cogs"></i></a></h5>
								</div>
							</div>
						</div>
						<br><h4>Rôles d'initiateur et de valideur</h4>
						<div class="kt-section__content kt-section__content--solid">
							<div class="row">
								<div class="col-md-12">
									<h5 class="{{ $valideur_pieces == 0 ? 'text-danger' : 'text-success' }}">Valideurs de pièces : {{ $valideur_pieces }} <a href="/comptes/profils"><i class="fa fa-cogs"></i></a></h5>
									<h5 class="{{ $initier_chantiers == 0 ? 'text-danger' : 'text-success' }}">Initier chantier : {{ $initier_chantiers }} <a href="/comptes/profils"><i class="fa fa-cogs"></i></a></h5>
									<h5 class="{{ $valideur_intervenants == 0 ? 'text-danger' : 'text-success' }}">Valideurs de chantiers : {{ $valideur_intervenants }} <a href="/comptes/profils"><i class="fa fa-cogs"></i></a></h5>
									<h5 class="{{ $initier_livraisons == 0 ? 'text-danger' : 'text-success' }}">Initier livraisons : {{ $initier_livraisons }} <a href="/comptes/profils"><i class="fa fa-cogs"></i></a></h5>
									<h5 class="{{ $valideur_livraisons == 0 ? 'text-danger' : 'text-success' }}">Valideurs de livraisons : {{ $valideur_livraisons }} <a href="/comptes/profils"><i class="fa fa-cogs"></i></a></h5>
								</div>
							</div>
						</div>
						<br><h4>Pièces</h4>
						<div class="kt-section__content kt-section__content--solid">
							<div class="row">
								<div class="col-md-12">
									<h5 class="{{ $pieces_oblig == 0 ? 'text-danger' : 'text-success' }}">Choix des pièces obligatoires : {{ $pieces_oblig == 1 ? 'Fait' : 'A Faire' }} <a href="/comptes/pieces"><i class="fa fa-cogs"></i></a></h5>
									<h5 class="{{ $habilitations == 0 ? 'text-danger' : 'text-success' }}">Choix des pièces habilitations : {{ $habilitations == 1 ? 'Fait' : 'A Faire' }} <a href="/comptes/habilitations"><i class="fa fa-cogs"></i></a></h5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<!--End::Dashboard 1-->
</div>
<!--End::Section-->
@endsection
