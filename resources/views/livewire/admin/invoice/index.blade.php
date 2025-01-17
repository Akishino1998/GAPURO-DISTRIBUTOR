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
                                    <div class="info-box {{ ($idInvoice == $item->id)?"transaksi-selected":"" }}" style="height: 55px;min-height:55px;margin-bottom:3px;cursor:pointer"  wire:click="setAktivitas({{ $item->id }})">
                                        <span class="info-box-icon bg-info" style="font-size: 1rem;width:40px !important;height: 40px;">
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
                            <div class="card-title"><strong>Informasi Transaksi</strong> </div>
                        </div>
                        <div class="card-body" >
                            <div class="row">
                                <div class="col-12 mt-2 mb-4">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('sparepart.print',[$dataAktivitas->Penjualan->id]) }}" target="_blank" class="btn btn-primary mr-5 "><i class="fas fa-print    "></i> Cetak Struk </a>
                                        <span class="btn btn-primary" data-toggle="modal" data-target="#refund-barang"  wire:click="refund({{ $dataAktivitas->Penjualan->id }})"><i class="fas fa-undo-alt"></i> Refund </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <strong><i class="fas fa-receipt mr-1"></i> Kode Penjualan / Invoice</strong>
                                    <p class="text-muted">
                                        {{ $dataAktivitas->Penjualan->kode_penjualan }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <strong><i class="fas fa-money-check mr-1"></i> Pembayaran</strong>
                                    <p class="text-muted">
                                        @if ($dataAktivitas->Penjualan->id_pembayaran == 1)
                                            Tunai
                                        @elseif ($dataAktivitas->Penjualan->id_pembayaran == 2)
                                            {{ $dataAktivitas->Penjualan->Bank->nama_bank }}
                                        @elseif ($dataAktivitas->Penjualan->id_pembayaran == 3)
                                            Split Pembayaran
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <strong><i class="fas fa-calendar mr-1"></i> Tgl. Transaksi</strong>
                
                                    <p class="text-muted">
                                        {{ date("H:i", strtotime($dataAktivitas->Penjualan->waktu_transaksi)) }} - {{ date("d F Y", strtotime($dataAktivitas->Penjualan->tgl_transaksi)) }} 
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <strong><i class="fas fa-user mr-1"></i> Pelanggan</strong>
                                    <p class="text-muted">
                                        {{ ($dataAktivitas->Penjualan->id_pelanggan == null )?"-":$dataAktivitas->Penjualan->Pelanggan->nama }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <strong><i class="fas fa-user mr-1"></i> Admin</strong>
                                    <p class="text-muted">
                                        {{ ($dataAktivitas->Penjualan->id_admin == null )?"-":$dataAktivitas->Penjualan->Admin->name }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <strong><i class="fas fa-book mr-1"></i> Keterangan</strong>
                                    <p class="text-muted">
                                        {!! ( $dataAktivitas->keterangan == "" || $dataAktivitas->keterangan == null)?"-":$dataAktivitas->keterangan !!}
                                    </p>
                                </div>
                                <div class="col-12">
                                    @if ($dataAktivitas->Penjualan->id_pembayaran == 3)
                                        <div class="media py-4 border-top mt-0">
                                            <div class="media-body mr-5">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6>Keterangan Pembayaran Split</h6> 
                                                    </div>
                                                    <div class="col-12 ">
                                                        @foreach ($dataAktivitas->Penjualan->SplitPembayaran as $item)
                                                            <div class="info-box" style="height: 55px;min-height:55px;margin-bottom:3px;cursor:pointer">
                                                                <span class="info-box-icon bg-info" style="font-size: 1rem;width:40px !important;height: 40px;">
                                                                    @if ($item->id_pembayaran == 1)
                                                                        <i class="fas fa-money-bill "></i>
                                                                    @elseif ($item->id_pembayaran == 2)
                                                                        <i class="fas fa-money-check"></i>
                                                                    @endif
                                                                </span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text" style="line-height:1;"> 
                                                                        @if ($item->id_pembayaran == 1)
                                                                            Tunai
                                                                        @elseif ($item->id_pembayaran == 2)
                                                                            {{ $item->Bank->nama_bank }}
                                                                        @endif
                                                                    </span>
                                                                    <span class="info-box-number" style="margin-top:0px">{{ "Rp. " .  number_format($item->jumlah, 0, ",", ".") }}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if (COUNT($dataAktivitas->Penjualan->Refund)>0)
                                        <div class="media py-4 border-top mt-0">
                                            <div class="media-body mr-5">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6>Keterangan Refund</h6> 
                                                    </div>
                                                    <div class="col-12 ">
                                                        @foreach ($dataAktivitas->Penjualan->Refund as $item)
                                                            @php
                                                                $idAktivitas = $item->getIdAktivitas($item->id);
                                                            @endphp
                                                            <div class="info-box" style="height: 55px;min-height:55px;margin-bottom:3px;cursor:pointer" @if($item->getIdAktivitas($item->id) != false) wire:click="setAktivitas({{ $item->getIdAktivitas($item->id)->id }})" @endif>
                                                                <span class="info-box-icon bg-info" style="font-size: 1rem;width:40px !important;height: 40px;">
                                                                    @if ($item->id_pembayaran == 1)
                                                                        <i class="fas fa-money-bill "></i>
                                                                    @elseif ($item->id_pembayaran == 2)
                                                                        <i class="fas fa-money-check"></i>
                                                                    @endif
                                                                </span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text" style="line-height:1;"> 
                                                                        {{ $item->kode_refund }}
                                                                    </span>
                                                                    <span class="info-box-number" style="margin-top:0px">{{ date("d F Y", strtotime($item->tgl_refund)) }}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="media py-4 border-top mt-0">
                                        <div class="media-body mr-5">
                                            <div class="table-responsive ">
                                                <table class="table table-bordered text-nowrap border-top table-sm">
                                                    <tbody>
                                                        @foreach ($dataAktivitas->Penjualan->belanjaDetail as $item)
                                                        <tr>
                                                            <td colspan="4">
                                                                <h6 class="mb-0 font-weight-bold">{{ $item->Sparepart->nama_part." - ".$item->Sparepart->Kategori->kategori." - ".$item->Sparepart->Merk->merk }} 
                                                                </h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 50px">
                                                                <div class="input-group">
                                                                    <input type="text" name="quantity" class="form-control text-center qty" value="{{ $item->qty }}" readonly="" style="height: 30px !important">
                                                                </div>
                                                            </td>
                                                            <td class="price number-font1" style="vertical-align: middle;text-align:center">{{ "Rp. " .  number_format($item->harga_jual, 0, ",", ".") }}</td>
                                                            <td class="number-font1" style="vertical-align: middle;text-align:right">{{ "Rp. " .  number_format($item->harga_jual*$item->qty, 0, ",", ".") }}</td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td style="text-align: left" colspan="2">
                                                                <span class="font-weight-bold">Total</span>
                                                            </td>
                                                            <td style="text-align: right">
                                                                <span>{{ "Rp. " .  number_format($dataAktivitas->Penjualan->grand_total+$dataAktivitas->Penjualan->diskon, 0, ",", ".") }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left" colspan="2">
                                                                <span class="font-weight-bold">Diskon</span>
                                                            </td>
                                                            <td style="text-align: right">
                                                                <span>{{ "Rp. " .  number_format($dataAktivitas->Penjualan->diskon, 0, ",", ".") }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left" colspan="2">
                                                                <span class="font-weight-bold">Grand Total</span>
                                                            </td>
                                                            <td style="text-align: right">
                                                                <span>{{ "Rp. " .  number_format($dataAktivitas->Penjualan->grand_total, 0, ",", ".") }}</span>
                                                            </td>
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
    const now = new Date();
    var today = new Date(now.getFullYear(), now.getMonth(), 1);
    var endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
    $("#time_start").val(formatDate(today));
    $("#time_end").val(formatDate(endDate));
    startDates = formatDate(today);
    endDates = formatDate(endDate);
    
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
    
</script>
@endsection