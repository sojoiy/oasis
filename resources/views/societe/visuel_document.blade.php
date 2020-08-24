<!--begin:: Widgets/New Users-->
<div class="kt-portlet kt-portlet--head--noborder kt-portlet--height-fluid">
	<div class="card-header">
		<div class="card-title">
			<h3>
				{{ $document->type_piece }}
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="dropdown dropdown-inline">
				<a href="/temp/{{ $key }}.{{ $document->extension }}" target="_blank" class=" btn btn-clean btn-sm btn-icon btn-icon-lg">
					<i class="fa fa-download text-info"></i>
				</a>
				<button type="button" onclick="if(confirm('Souhaitez-vous supprimer ce document ?')){supprimerDocument({{  $document->id }})}" class=" btn btn-clean btn-sm btn-icon btn-icon-lg">
					<i class="fa fa-trash text-danger"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		@if($document->extension == 'pdf')
			<iframe src = "/temp/ViewerJS/#../{{ $key }}.pdf" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
		@else
			<img src="/temp/{{ $key }}.{{ $document->extension }}" width="300" />
		@endif
	</div>
	<!--end::Form-->
</div>