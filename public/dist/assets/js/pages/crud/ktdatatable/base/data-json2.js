"use strict";
// Class definition

var KTDatatableJsonRemoteDemo = function() {
    // Private functions

    // basic demo
    var demo = function() {
        var datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                
                pageSize: 10,
                source:{
                     
                    read:{
                        url: HOST_URL,
                        method:'GET',
                    },
                },
                
            },
             

            // layout definition
            layout: {
                scroll: true, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false // display/hide footer
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },
            rows:{
                autoHide: false,
            },

            // columns definition
            columns: [{
                field: 'no',
                title: 'No',
                width: 50,
                textAlign: 'center',
            }, {
                field: 'kodeServisan',
                title: 'No. Servis',
                textAlign: 'center',
                width: 110,
            }, {
                field: 'tglMasuk',
                title: 'TGL TERIMA',
                width: 100,
            }, {
                field: 'adminPenerima',
                title: 'PENERIMA',
                width: 90,
            }, {
                field: 'namaBarang',
                title: 'NAMA BARANG',
                width: 70,
        
            }, {
                field: 'pelanggan',
                title: 'PEMILIK',
                width: 70,
            }, {
                field: 'kerusakan',
                title: 'KERUSAKAN',
            }, {
                field: 'tingkat_kesulitan',
                title: 'KESULITAN',
                template: function(row) {
                    var tingkatKesulitan = {
                        null: {
                            'title': 'Belum Ditentukan',
                            'state': 'secondary'
                        },
                        "Mudah": {
                            'title': 'Mudah',
                            'state': 'success'
                        },
                        "Sedang": {
                            'title': 'Sedang',
                            'state': 'warning'
                        },
                        "Sulit": {
                            'title': 'Sulit',
                            'state': 'danger'
                        },
                    };
                    return  '<button type="button" class="btn btn-sm btn-'+tingkatKesulitan[row.tingkat_kesulitan].state+'" data-toggle="modal" data-target="#modalKesulitan" data-whatever="'+row.idServisan+'">'+tingkatKesulitan[row.tingkat_kesulitan].title+'</button>';
                },
            }, {
                field: 'status',
                title: 'STATUS',
                template: function(row) {
                    var statusServis = {
                        1: {
                            'title': 'Proses Servis',
                            'state': 'warning'
                        },
                        2: {
                            'title': 'Belum Dikerjakan',
                            'state': 'dark'
                        },
                    };
                    return '<span class="label  label-light-'+statusServis[row.status].state+' label-inline mr-1 p-5">'+statusServis[row.status].title+'</span>';
                },
            }, {
                field: 'biaya_konfirmasi',
                title: 'BIAYA',
                template: function(row) {
                    var biayaKonfirmasi = {
                        1: {
                            'title': 'Proses Servis',
                            'state': 'warning'
                        },
                        2: {
                            'title': 'Belum Dikerjakan',
                            'state': 'dark'
                        },
                    };
                    return '<span class="label  label-light-'+biayaKonfirmasi[row.status].state+' label-inline mr-1 p-5">'+biayaKonfirmasi[row.status].title+'</span>';
                },
            }, { 
                field: 'lama_hari',
                title: 'LAMA(HARI)',
                template: function(row) {
                    var biayaKonfirmasi = {
                        1: {
                            'title': 'Proses Servis',
                            'state': 'warning'
                        },
                        2: {
                            'title': 'Belum Dikerjakan',
                            'state': 'dark'
                        },
                    };
                    return '<span class="label  label-light-'+biayaKonfirmasi[row.status].state+' label-inline mr-1 p-5">'+biayaKonfirmasi[row.status].title+'</span>';
                },
            }, {
                field: 'kerusakan',
                title: '#',
            }],

        });

        $('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase());
        });
    };

    return {
        // public functions
        init: function() {
            demo();
        }
    };
}();

jQuery(document).ready(function() {
    KTDatatableJsonRemoteDemo.init();
});
