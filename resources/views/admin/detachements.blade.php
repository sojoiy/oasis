@extends('layout.default')

@section('content')
<link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />
<!-- begin:: Content Head -->

<!-- end:: Content Head -->

<!-- begin:: Content -->

	<div class="row">
		<div class="col-lg-12">
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Informations</h3>
					</div>
				</div> 

				<div class="card-body">
					<form class="kt-form" method="POST" action="/admin/savepays">
						{{ csrf_field() }}
						<div class="kt-section kt-section--first">
							@foreach($zones as $zone_soc)
								@foreach($zones as $zone_ent)
									<div class="form-group row">
										<label class="col-form-label text-right col-lg-4 col-sm-12">Zone {{ $zone_soc->libelle }} & {{ $zone_ent->libelle }}</label>
										<div class="col-lg-6 col-md-9 col-sm-12">
											<input id="kt_tagify_{{ $zone_soc->id }}_{{ $zone_ent->id }}" onchange="addPieceDetachement({{ $zone_soc->id }}, {{ $zone_ent->id }}, this.value)" class="form-control tagify" placeholder='Ajouter un type de pièce...' value='{{ $detachement->getValue($zone_soc->id, $zone_ent->id) }}' data-blacklist='' />
										</div>
									</div>
								@endforeach
							@endforeach
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
		</div>
	</div>
	
	<script type="text/javascript">
		var KTTagifyDemos = function() {
		    // Private functions
    	
			@foreach($zones as $zone_soc)
				@foreach($zones as $zone_ent)
			    	var demo{{ $zone_soc->id }}{{ $zone_ent->id }} = function() {
			    	        var input = document.getElementById('kt_tagify_{{ $zone_soc->id }}_{{ $zone_ent->id }}');
			    	        var tagify = new Tagify(input, {
			    	            enforceWhitelist: true,
			    	            whitelist: [@php foreach($pieces as $piece) echo "'".$piece->abbreviation."', "  @endphp],
			    	            callbacks: {
			    	                add: addPieceDetachement({{ $zone_soc->id }}, {{ $zone_ent->id }}), // callback when adding a tag
			    	                remove: removePieceDetachement({{ $zone_soc->id }}, {{ $zone_ent->id }}) // callback when removing a tag
			    	            }
			    	        });
			    	    }
				@endforeach
			@endforeach

		    return {
		        // public functions
		        init: function() {
					@foreach($zones as $zone_soc)
						@foreach($zones as $zone_ent)
								demo{{ $zone_soc->id }}{{ $zone_ent->id }}();
						@endforeach
					@endforeach
		        }
		    };
		}();
	</script>
@endsection

@section('specifijs')
	
	<script src="{{ asset('assets/js/admin.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/pages/crud/forms/widgets/tagify.js?v=7.0.5') }}" type="text/javascript"></script>
@endsection