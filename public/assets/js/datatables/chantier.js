"use strict";
// Class definition

var KTDefaultDatatableDemo = function () {
	// Private functions

	// basic demo
	var demo = function () {

		var datatable = $('.kt-datatable').KTDatatable({
			data: {
				type: 'remote',
				source: {
					read: {
						url: '/results',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
					}
				},
				pageSize: 20,
				serverPaging: true,
				serverFiltering: true,
				serverSorting: true
			},

			layout: {
				scroll: true,
				height: 550,
				footer: false
			},

			sortable: true,

			filterable: false,

			pagination: true,

			search: {
				input: $('#generalSearch')
			},

			columns: [
				{
					field: 'Numero',
					title: 'N° Chantier',
				}, {
					field: 'Type',
					title: 'Type',
				}, {
					field: 'Initiateur',
					title: 'Initiateur',
				}, {
					field: 'Prestataire',
					title: 'Prestataire(s)',
				}, {
					field: 'Date',
					title: 'Date',
					type: 'date',
					format: 'MM/DD/YYYY',
				}, {
					field: 'Statut',
					title: 'Statut',
					autoHide: false,
					// callback function support for column rendering
					template: function(row) {
						var status = {
							"en_cours": {'title': 'En cours', 'state': 'warning'},
							2: {'title': 'Retail', 'state': 'primary'},
							3: {'title': 'Direct', 'state': 'success'},
						};
						return '<span class="kt-badge kt-badge--' + status[row.Statut].state + ' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-' + status[row.Statut].state + '">' +
								status[row.Statut].title + '</span>';
					},
				}, {
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 100,
					textAlign: 'center',
					overflow: 'visible',
					autoHide: false,
					template: function(row) {
						return '\
							<a href="/admin/chantier/'+ row.ChantierID +'" class="btn btn-xs btn-clean btn-icon btn-icon-md" title="Edit details">\
								<i class="fa fa-eye"></i>\
							</a>\
							<a href="/admin/deletechantier/'+ row.ChantierID +'" class="btn btn-xs btn-clean btn-icon btn-icon-md" title="Delete">\
								<i class="fa fa-trash"></i>\
							</a>\
						';
					},
				}],

		});

    $('#kt_form_status').on('change', function() {
      datatable.search($(this).val().toLowerCase(), 'Status');
    });

    $('#kt_form_type').on('change', function() {
      datatable.search($(this).val().toLowerCase(), 'Type');
    });

    $('#kt_form_status,#kt_form_type').selectpicker();

  };

	return {
		// public functions
		init: function () {
			demo();
		}
	};
}();

jQuery(document).ready(function () {
	KTDefaultDatatableDemo.init();
});