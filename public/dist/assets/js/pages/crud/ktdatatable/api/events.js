'use strict';
// Class definition

var KTDefaultDatatableDemo = function() {
	// Private functions

	// basic demo
	var demo = function() {

		var datatable = $('#kt_datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: 'http://localhost:8000/api/getServisan/toko/1',
						method:'GET',
					},
					
				},
				pageSize: 5, // display 20 records per page
				serverPaging: true,
				serverFiltering: true,
				serverSorting: true,
			},

			// layout definition
			layout: {
				scroll: true, // enable/disable datatable scroll both horizontal and vertical when needed.
				minHeight: null, // datatable's body's fixed height
				footer: false, // display/hide footer
			},

			// column sorting
			sortable: true,

			// toolbar
			toolbar: {
				// toolbar placement can be at top or bottom or both top and bottom repeated
				placement: ['bottom'],

				// toolbar items
				items: {
					// pagination
					pagination: {
						// page size select
						pageSizeSelect: [5, 10, 20, 30, 50], // display dropdown to select pagination size. -1 is used for "ALl" option
					},
				},
			},

			search: {
				input: $('#kt_datatable_search_query'),
				key: 'generalSearch'
			},
			row:{
				autoHide: false,
			},
			// columns definition
			columns: [
				{
					field: 'no',
					title: 'No',
					width:'50',
					textAlign: 'center'
				}, {
					field: 'tglMasuk',
					title: 'Tgl Terima',
					type: 'date',
					format: 'd/m/YYYY',
					width:'80',
				},{
					field: 'penerima',
					title: 'penerima',
					width:'90',
				}, {
					field: 'jenisElektronik',
					title: 'Jenis',
					textAlign: 'center',
					width:'50',
				},{
					field: 'merkType',
					title: 'Merk/Type',
					textAlign: 'center'
				},{
					field: 'pelanggan',
					title: 'Pemilik',
					width:'130',
					template: function(row) {
						return row.pelanggan + '<button data-placement="bottom"  data-toggle="tooltip" title="'+no_hp+'" onclick="openWA('+row.no_wa+','+row.namaToko+')" class="btn btn-light-success font-weight-bold btn-icon btn-sm"><i class="fab la-whatsapp"></i></button>';
					},
				},{
					field: 'kerusakan',
					title: 'Kerusakan',
				},{
					field: 'status',
					title: 'Status',
					sortable: false,
					// callback function support for column rendering
					template: function(row) {
						var status = {
							1: {'title': 'Pending', 'class': 'label label-lg label-light-primary label-inline'},
							2: {'title': 'Progress', 'class': 'label label-lg label-light-warning label-inline'},
						};
						return '<span class=" ' + status[row.status].class + '">' + status[row.status].title + '</span>';
					},
				}, {
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 125,
					textAlign: 'center',
					overflow: 'visible',
					autoHide: false,
					template: function(row) {
						if(row.status == 2){
							return '<button type="button" class="btn btn-primary btn-icon btn-sm"  data-toggle="modal" data-target="#modalUpdateStatusMasuk" data-whatever="'+row.idToko+'" data-placement="bottom"  data-toggle="tooltip" title="Update Status Servis"><i class="fa fa-pencil-alt"></i></button>';
						}else{
							return `<button type="button" class="btn btn-info btn-icon btn-sm"  data-toggle="modal" data-target="#modalUpdateStatusMasukInfo" data-whatever="`+row.idToko+`" data-placement="bottom"  data-toggle="tooltip" title="Lihat Progress" onclick="showProgress('`+row.idToko+`')"><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-primary btn-icon btn-sm"  data-toggle="modal" data-target="#modalUpdateStatusMasukProgress" data-whatever="`+row.idToko+`" data-placement="bottom"  data-toggle="tooltip" title="Update Status Servis"><i class="fa fa-edit"></i></button>`;
						}
						
					},
				},
				],

		});

		$('#kt_datatable_search_status').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'status');
		});

		$('#kt_datatable_search_type').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();

	};

	var eventsCapture = function() {
		$('#kt_datatable').on('datatable-on-init', function() {
			eventsWriter('Datatable init');
		}).on('datatable-on-layout-updated', function() {
			eventsWriter('Layout render updated');
		}).on('datatable-on-ajax-done', function() {
			eventsWriter('Ajax data successfully updated');
		}).on('datatable-on-ajax-fail', function(e, jqXHR) {
			eventsWriter('Ajax error');
		}).on('datatable-on-goto-page', function(e, args) {
			eventsWriter('Goto to pagination: ' + args.page);
		}).on('datatable-on-update-perpage', function(e, args) {
			eventsWriter('Update page size: ' + args.perpage);
		}).on('datatable-on-reloaded', function(e) {
			eventsWriter('Datatable reloaded');
		}).on('datatable-on-check', function(e, args) {
			eventsWriter('Checkbox active: ' + args.toString());
		}).on('datatable-on-uncheck', function(e, args) {
			eventsWriter('Checkbox inactive: ' + args.toString());
		}).on('datatable-on-sort', function(e, args) {
			eventsWriter('Datatable sorted by ' + args.field + ' ' + args.sort);
		});
	};

	var eventsWriter = function(string) {
		var console = $('#kt_datatable_console').append(string + '\t\n');
		$(console).scrollTop(console[0].scrollHeight - $(console).height());
	};

	return {
		// public functions
		init: function() {
			demo();
			eventsCapture();
		},
	};
}();

jQuery(document).ready(function() {
	KTDefaultDatatableDemo.init();
});
