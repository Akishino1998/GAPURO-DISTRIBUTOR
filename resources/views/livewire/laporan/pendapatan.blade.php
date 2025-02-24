@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .optionSelectPembayaran{
            background: #705ec8;
            color: white;
        }
        .info-box .info-box-content{
            justify-content:flex-start !important
        }
        .transaksi-selected{
            background: #c4c4c4;
        }
        .info-box .info-box-content{
            line-height: 1.2 !important;
        }
        a{
            color: black;
        }
    </style>
@endsection
<div>
    <div class="card">
        <div class="row no-gutters">
            <div class="col-lg-4 col-xl-3">
                <div class="border-right">
                    <div class="main-content-left main-content-left-contacts" style="height:100vh">
                        <div class="card-header">
                            <div class="card-title"><strong>Transaksi</strong> </div>
                        </div>
                        <input type="hidden" name="time_start" id="time_start">
                        <input type="hidden" name="time_end" id="time_end">
                        <input id="date_range" class="datepicker-here form-control digits" autocomplete="off" readonly required style="font-size: 12px;">
                        <div class="main-contacts-list" id="mainContactList" style="overflow:scroll;height: 80vh;" wire:ignore.self>
                            @foreach ($invoice->groupBy('tgl_terbit') as $item => $value)
                                <div class="card card-info card-outline" style="padding-top: 5px !important;margin-bottom:0px;display:none">
                                    <div class="card-header" style="padding: 0px">
                                        <p class="info-box-number text-center" style="margin-bottom:3px;">{{ date("d F Y", strtotime($item)) }}</p>
                                    </div>
                                </div>
                                <div class="card card-info card-outline" style="padding-top: 5px !important;margin-bottom:0px">
                                    <div class="card-header" style="padding: 0px">
                                        <p class="info-box-number text-center" style="margin-bottom:3px;">{{ date("d F Y", strtotime($item)) }}</p>
                                    </div>
                                </div>
                                @foreach ($value as $item)
                                    <div class="info-box {{ ($idInvoiceSelect == $item->id)?"transaksi-selected":"" }}" style="height: 55px;min-height:55px;margin-bottom:3px;cursor:pointer"  wire:click="setInvoice({{ $item->id }})">
                                        <span class="info-box-icon bg-{{ $item->colorStatus($item->status) }}" style="font-size: 1rem;width:40px !important;height: 40px;">
                                            @if ($item->status == 1)
                                                <i class="fas fa-file-alt"></i>
                                            @elseif ($item->status == 2)
                                                <i class="fas fa-file-invoice"></i>
                                            @elseif ($item->status == 3)
                                                <i class="fas fa-money-check"></i>
                                            @endif
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text" style="line-height:1.2;">{{ "Rp. " .  number_format($item->Pemesanan->totalPemesanan($item->id_pemesanan), 0, ",", ".") }} <span style="float: right">{{ date("H:i", strtotime($item->tgl_terbit)) }}</span>
                                            <span class="info-box-number" style="margin-top:0px">{{ $item->no_invoice }}</span>
                                        </div>
                                    </div>
                                @endforeach 
                            @endforeach
                            @if (COUNT($invoice)>0)
                                @if (COUNT($invoice)>=$limitPerPage)
                                    <div>
                                        <div class="d-flex justify-content-center mb-3">
                                            <button class="btn btn-primary btn-sm"  wire:loading.remove onclick="getNextData()" wire:target='loadMore' >  Lihat lainnya </button>
                                            <button class="btn btn-secondary btn-sm" wire:loading.flex wire:target='loadMore' > <i class="fas fa-spinner fa-spin   " ></i>  Lihat lainnya </button>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div>
                                    <div class="alert alert-info" role="alert">Tidak ada transaksi</div> 
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="card border-primary"  wire:loading.flex wire:target='setAktivitas'>
                    <div class="card-header">
                        <div class="card-title"><strong>Informasi Transaksi</strong> </div>
                    </div>
                    <div class="card-body" >
                        <div class="container">
                            <div class="row">
                                <div class="d-flex justify-content-center">
                                    <i class="fas fa-spinner fa-3x fa-spin   "></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($jenis_transaksi == 0)
                    <div class="card border-primary" wire:loading.remove wire:target="setAktivitas">
                        <div class="card-header">
                            <div class="card-title"><strong>Informasi Transaksi</strong> </div>
                        </div>
                        <div class="card-body" >
                            <div >
                                <div class="alert alert-info" role="alert">Pilih Transaksi</div>
                            </div>
                        </div>
                    </div>
                @elseif ($jenis_transaksi == 1)
                    <div class="card border-primary" wire:loading.remove wire:target="setAktivitas">
                        <div class="card-header">
                            <div class="card-title"><strong>Informasi Pemesanan</strong> </div>
                        </div>
                        <div class="card-body" >
                            <div class="row">
                                <div class="col-12">
                                    <div class="invoice p-3 mb-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>
                                                    TOKO SAYUR <b>KASMI</b>  
                                                    <small class="float-right">{{  \Carbon\Carbon::parse($invoiceSelect->tgl_terbit)->translatedFormat('l, d F Y')  }}</small>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="row invoice-info mb-4">
                                            <div class="col-sm-3 invoice-col">
                                                TAGIHAN DARI,
                                                <address>
                                                    <strong>TOKO SAYUR KASMI</strong><br>
                                                </address>
                                            </div>
                                            <div class="col-sm-3 invoice-col">
                                                DITUJUKAN KEPADA,
                                                <address>
                                                    <strong>{{ $invoiceSelect->Konsumen->name }}</strong><br>
                                                </address>
                                            </div>
                                            <div class="col-sm-6 invoice-col mb-2">
                                                <b>No. Invoice:</b>  <a href="{{ route('admin.pemesanan.show',$invoiceSelect->id_pemesanan) }}" target="_blank">{{ $invoiceSelect->no_invoice }} <i class="fas fa-external-link-alt"></i></a><br>
                                                <b>Tgl. Pesan:</b> {{  \Carbon\Carbon::parse($invoiceSelect->Pemesanan->tgl_pemesanan)->translatedFormat('l, d F Y')  }}<br>
                                                <b>Tgl. Pelunasan:</b> {{  ($invoiceSelect->tgl_bayar==null)?"-":\Carbon\Carbon::parse($invoiceSelect->tgl_bayar)->translatedFormat('l, d F Y')  }}<br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-striped table-hover table-bordered">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th rowspan="2">No</th>
                                                            <th rowspan="2">Jenis Barang</th>
                                                            <th colspan="3">Permintaan</th>
                                                            <th colspan="3">Pembelian</th>
                                                            <th rowspan="2">Pendapatan </th>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th>Qty</th>
                                                            <th>Harga Satuan</th>
                                                            <th>Total</th>
                                                            <th>Qty</th>
                                                            <th>Harga Satuan</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $totalPendapatan = 0;
                                                        @endphp
                                                        @foreach ($invoiceSelect->Pemesanan->PemesananDetail->where('status_barang_user',1) as $item)
                                                           
                                                            <tr class="text-center">
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item->Barang->nama_barang }}</td>
                                                                <td>{{ $item->qty }} {{ $item->Satuan->satuan }}</td>
                                                                <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}</td>
                                                                <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty, 0, ",", ".") }}</td>
                                                                
                                                                <td>{{ $item->Penyiapan->SUM('qty') }} {{ $item->Satuan->satuan }}</td>
                                                                <td>{{ ($item->Penyiapan==null)?"-":"Rp. " .  number_format($item->Penyiapan->SUM('harga_satuan'), 0, ",", ".") }}</td>
                                                                <td>{{ ($item->Penyiapan==null)?"-":"Rp. " .  number_format($item->Penyiapan->SUM('harga_satuan')*$item->Penyiapan->SUM('qty'), 0, ",", ".") }}</td>

                                                                <td>{{ ($item->Penyiapan==null)?"-":"Rp. " .  number_format(($item->harga_per_satuan*$item->qty)-($item->Penyiapan->SUM('harga_satuan')*$item->Penyiapan->SUM('qty')), 0, ",", ".") }}</td>
                                                                @php
                                                                    $totalPendapatan +=($item->harga_per_satuan*$item->qty)-($item->Penyiapan->SUM('harga_satuan')*$item->Penyiapan->SUM('qty'));
                                                                @endphp
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <th colspan="4" class=" text-lg">Total Pendapatan</th>
                                                            <th colspan="3">
                                                                <input class="form-control text-center text-lg text-bold {{ ($totalPendapatan>0)?'bg-success':'bg-danger' }}" required="true"  type="text" value="{{ "Rp. " .  number_format($totalPendapatan, 0, ",", ".") }}" readonly>
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div wire:poll.keep-alive>
        @if (session()->has('message'))
            <script>
                Toast.fire({
                    icon: 'success',
                    title: '{{ session("message") }}'
                });
                $('#closeModalRefund').click(); 
                $('#closeModalTambahSparepartServisan').click(); 
            </script>
        @endif
    </div>
</div>
@section('js')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
    let startDates = "";
    let endDates = "";
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }
    setInterval(function () {
        $('.uang').mask('000.000.000.000', {
            reverse: true
        });
    }, 500);
    var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    $('#penjualan-table').DataTable({
        paging: false,
        "order": [],
        bFilter: false, 
        bInfo: false
    });

    
    $('#date_range').daterangepicker({
        locale: {
            format: 'DD MMMM YYYY'
        }
    }, function(start, end, label) {
        $("#time_start").val(start.format('YYYY-MM-DD'));
        $("#time_end").val(end.format('YYYY-MM-DD'));
        @this.call('set_date',start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))
    });
    function getNextData(){
        @this.call('loadMore')
    }
    function setDate(today,endDate){
        $('#date_range').daterangepicker({
            startDate: today,
            endDate: endDate,
            locale: {
                format: 'DD MMMM YYYY'
            }
        }, function(start, end, label) {
            $("#time_start").val(start.format('YYYY-MM-DD'));
            $("#time_end").val(end.format('YYYY-MM-DD'));
            @this.call('set_date',start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
        });
    }
    $(document).ready(function () {
        const now = new Date();
        var today = new Date(now.getFullYear(), now.getMonth(), 1);
        var endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        setDate(today,endDate);
    });
</script>
@endsection