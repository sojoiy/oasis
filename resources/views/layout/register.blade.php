<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
	
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
		WebFont.load({
			google: {
				"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700", "Montserrat:300,400,500,600,700"]
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
	<!--end::Fonts -->

	<!--begin::Page Vendors Styles(used by this page) -->
	<link href="{{ asset('assets/css/demo1/pages/general/wizard/wizard-4.css') }}" rel="stylesheet" type="text/css" />
	
	<!--end::Page Vendors Styles -->

	<!--begin:: Global Mandatory Vendors -->
	<link href="{{ asset('assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	
	<!--end:: Global Mandatory Vendors -->
	
	<link href="{{ asset('assets/css/demo1/style.bundle.css') }}" rel="stylesheet" type="text/css" />

	<!--end::Global Theme Styles -->

	<!--begin::Layout Skins(used by all pages) -->
	<link href="{{ asset('assets/css/demo1/skins/header/base/light.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/avada.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/demo1/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/demo1/skins/brand/dark.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/demo1/skins/aside/dark.css') }}" rel="stylesheet" type="text/css" />

	@yield('specificss')
	
	<!--end::Layout Skins -->
	<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    
			<!-- begin:: Page -->
	
			<div class="kt-grid kt-grid--hor kt-grid--root">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
	
					<!-- begin:: Aside -->
					<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
					<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
	
						<!-- end:: Aside -->
						<a href="http://site.oasis-dev.pro" class="label">OASIS EDX.</a>
						<!-- end:: Aside Menu -->
					</div>
	
					<!-- end:: Aside -->
					<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
	
						<!-- end:: Header -->
						<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
							@yield('content')
						</div>

						<!-- begin:: Footer -->
						<div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
							<div class="kt-footer__copyright">
								2019&nbsp;&copy;&nbsp;<a href="http://wwww.itm-concepts.fr/" target="_blank" class="kt-link">ITM Concepts</a> | Avada Theme
							</div>
						</div>
	
						<!-- end:: Footer -->
					</div>
				</div>
			</div>

			<!-- end:: Page -->

			<!-- begin::Scrolltop -->
			<div id="kt_scrolltop" class="kt-scrolltop">
				<i class="fa fa-arrow-up"></i>
			</div>
	
			<!-- end::Scrolltop -->
	
			<!-- begin::Global Config(global config for global JS sciprts) -->
			<script>
				var KTAppOptions = {
					"colors": {
						"state": {
							"brand": "#5d78ff",
							"dark": "#282a3c",
							"light": "#ffffff",
							"primary": "#5867dd",
							"success": "#34bfa3",
							"info": "#36a3f7",
							"warning": "#ffb822",
							"danger": "#fd3995"
						},
						"base": {
							"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
							"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
						}
					}
				};
			</script>
	
			<!-- end::Global Config -->

			<!--begin:: Global Mandatory Vendors -->
			<script src="{{ asset('assets/vendors/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/moment/min/moment.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/sticky-js/dist/sticky.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/wnumb/wNumb.js') }}" type="text/javascript"></script>
	
			<!--end:: Global Mandatory Vendors -->

			<!--begin:: Global Optional Vendors -->
			<script src="{{ asset('assets/vendors/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/block-ui/jquery.blockUI.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-timepicker.init.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-switch.init.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/ion-rangeslider/js/ion.rangeSlider.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/typeahead.js/dist/typeahead.bundle.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/handlebars/dist/handlebars.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/nouislider/distribute/nouislider.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/autosize/dist/autosize.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/clipboard/dist/clipboard.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/dropzone/dist/dropzone.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/summernote/dist/summernote.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/markdown/lib/markdown.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-markdown.init.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/bootstrap-notify/bootstrap-notify.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-notify.init.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/jquery-validation/dist/jquery.validate.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/jquery-validation/dist/additional-methods.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/custom/js/vendors/jquery-validation.init.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/raphael/raphael.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/morris.js/morris.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/waypoints/lib/jquery.waypoints.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/counterup/jquery.counterup.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/es6-promise-polyfill/promise.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/vendors/general/dompurify/dist/purify.js') }}" type="text/javascript"></script>
			<link href="{{ asset('assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
			<link href="{{ asset('assets/vendors/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css" />
	
			<!--end:: Global Optional Vendors -->

			<!--begin::Global Theme Bundle(used by all pages) -->
			<script src="{{ asset('assets/js/demo1/scripts.bundle.js') }}" type="text/javascript"></script>
	
			<!--end::Global Theme Bundle -->

			<!--begin::Page Vendors(used by this page) -->
			
			<!--end::Page Vendors -->

			<!--begin::Page Scripts(used by this page) -->
			<script src="{{ asset('assets/js/demo1/pages/dashboard.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript"></script>
		    <script src="{{ asset('assets/vendors/custom/jstree/jstree.bundle.js') }}" type="text/javascript"></script>
			<script src="{{ asset('assets/js/demo1/pages/components/extended/treeview.js') }}" type="text/javascript"></script>
			
			<!--end::Page Scripts -->
			@yield('specifijs')

</body>
</html>
