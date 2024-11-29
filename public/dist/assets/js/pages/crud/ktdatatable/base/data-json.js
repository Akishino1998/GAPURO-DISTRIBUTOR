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
                width: 30,
                textAlign: 'center',
            }, {
                field: 'no_servis',
                title: 'No. Servis',
                textAlign: 'center',
                width: 80,
            }, {
                field: 'tglMasuk',
                title: 'TGL TERIMA',
                width: 80,
            }, {
                field: 'tglKeluar',
                title: 'TGL KELUAR',
                width: 80,
            }, {
                field: 'id_admin_toko_terima',
                title: 'PENERIMA',
                width: 80,
            }, {
                field: 'jenisElektronik',
                title: 'JENIS',
                width: 70,
               
            }, {
                field: 'merkType',
                title: 'MERK/TYPE',
                width: 90,
            }, {
                field: 'pelanggan',
                title: 'PEMILIK',
                width: 70,
            }, {
                field: 'teknisi',
                title: 'Teknisi',
                width: 70,
            }, {
                field: 'kerusakan',
                title: 'KERUSAKAN',
            }, {
                field: 'pendapatan',
                title: 'Pendapatan',
            }, {
                field: 'persentase_teknisi',
                title: 'Persentase Teknisi',
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
