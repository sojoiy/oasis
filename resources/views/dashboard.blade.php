@extends('layout.default')

@section('content')
<div class="container">
    <div class="row">
		<div class="col-xl-8">
			<div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
				<div class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
					<div class="kt-portlet__head-label">
						<h3 class="kt-portlet__head-title">
							Exclusive Datatable Plugin
						</h3>
					</div>
				</div>
				<div class="kt-portlet__body kt-portlet__body--fit">
					<div class="kt-datatable" id="kt_datatable_latest_orders"></div>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
