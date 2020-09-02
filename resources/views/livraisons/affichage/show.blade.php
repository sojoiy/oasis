@extends('layout.default')

<link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css" />

@section('content')

<!-- begin:: Content -->
@include('livraisons.modal_prorogation', ['livraison' => $livraison])					
					

	<!--begin::Entry-->
	<!--begin::Profile 4-->
	<div class="d-flex flex-row">
		<!--begin::Aside-->
		<div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
			<!--begin::Card-->
			<div class="card card-custom gutter-b">
				<!--begin::Body-->
				<div class="card card-custom">
					<div class="card-header">
						<div class="card-title">
							<h3>
								Livraison : {{ $livraison->numero }}
							</h3>
						</div>
					</div>
					<div class="card-body">
						<!--begin::Form-->
						<div class="pt-8 pb-6">
							<div class="d-flex align-items-center justify-content-between mb-2">
								<span class="font-weight-bold mr-2">Date de début :</span>
								{{ date('d/m/Y', strtotime($livraison->date_debut)) }}
							</div>
							<div class="d-flex align-items-center justify-content-between mb-2">
								<span class="font-weight-bold mr-2">Date de fin :</span>
								{{ date('d/m/Y', strtotime($livraison->date_fin)) }}
							</div>
						</div>
					</div>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Card-->
			<!--begin::Mixed Widget 14-->
			<div class="card card-custom gutter-b">
				<!--begin::Header-->
				<div class="card-header border-0 pt-5">
					<h3 class="card-title font-weight-bolder">Activité</h3>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body d-flex flex-column">
					<div class="example example-basic">
						<div class="example-preview">
							<!--begin::Timeline-->
							<div class="timeline timeline-2">
								<div class="timeline-bar"></div>
								
								@foreach($evenements as $event)
									<div class="timeline-item">
										<div class="timeline-badge"></div>
										<div class="timeline-content d-flex align-items-center justify-content-between">
											<span class="mr-3">
												<a href="#">{{ $event->description }}</a>
											</span>
											<span class="text-muted text-right">{{ date('d/m/y', strtotime($event->created_at)) }}</span>
										</div>
									</div>
								@endforeach
							</div>
							<!--end::Timeline-->
						</div>
					</div>
					
				</div>
				<!--end::Body-->
			</div>
			<!--end::Mixed Widget 14-->
		</div>
		<!--end::Aside-->
		<!--begin::Content-->
		<div class="flex-row-fluid ml-lg-8">
			<!--begin::Row-->
			<div class="row">
				<div class="col-lg-12">
					<!--begin::Mixed Widget 5-->
					<div class="card card-custom gutter-b">
						<!--begin::Header-->
						<!--end::Header-->
						<!--begin::Body-->
						<div class="card-header">
							<h3 class="card-title">Description</h3>
							<div class="card-toolbar">
								<div class="example-tools justify-content-center">
									<span class="example-toggle" data-toggle="tooltip" title="View code"></span>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div id="kt-ckeditor-1-toolbar"></div>
							<div id="kt-ckeditor-1">{{ $livraison->memo }}</div>
						</div>
						
						<!--begin::Stats
						@if($livraison->do == $user->societeID)
							<textarea name="memo" id="memo" rows="5" onkeyup="$('#save_memo').show();" class="form-control"></textarea>
						@else
							<p>{{ $livraison->memo }}</p>
						@endif
						<br><button type="button" onclick="saveMemo({{ $livraison->id }})" id="save_memo" class="btn btn-info btn-sm" style="display:none;"><i class="fa fa-save"></i> Enregistrer</button> -->
						<!--end::Stats-->
						<!--end::Body-->
					</div>
					<!--end::Mixed Widget 5-->
				</div>
				
			</div>
			<!--end::Row-->
		</div>
		<!--end::Content-->
	</div>
	<!--end::Profile 4-->
	
@endsection

@section('specifijs')
	<script src="{{ asset('assets/js/livraison.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-document.bundle.js?v=7.0.5') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/pages/crud/forms/editors/ckeditor-document.js?v=7.0.5') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js?v=7.0.5') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/pages/features/miscellaneous/treeview.js?v=7.0.5') }}" type="text/javascript"></script>
@endsection