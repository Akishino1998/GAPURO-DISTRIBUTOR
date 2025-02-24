@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<style>
    .select2-container .select2-selection--single {
        height: 40px;
    }

    input[type=radio]:not(:disabled)~label {
        cursor: pointer;
    }

</style>
@endsection
<div>
    <div class="content px-3 pt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a href="{{ route('pemesanan.index') }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a>  <strong>Informasi Pemesanan</strong>
                </h3>
                <div class="card-options float-right">
                    @if ($pemesanan->status == 3)
                        <button data-toggle="modal" data-target="#modalBatalkanPemesanan" class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i> Batalkan Pemesanan</button>
                    @elseif($pemesanan->status == 7)
                        <button data-toggle="modal" data-target="#modalPesananDiterima" class="btn btn-warning btn-sm"><i class="fas fa-hands"></i>  Pesanan sudah diterima?</button>
                    @elseif($pemesanan->status == 5)
                        <button class="btn btn-{{ $pemesanan->colorStatus($pemesanan->status) }} btn-sm">{!! $pemesanan->status($pemesanan->status) !!} </button>
                        <a href="{{ route('pemesanan.verifikasi',$pemesanan->id) }}" class="btn btn-warning btn-sm"><strong><i class="fas fa-tasks"></i> Verifikasi Pesanan</strong></a>
                    @else
                        <button class="btn btn-{{ $pemesanan->colorStatus($pemesanan->status) }} btn-sm">{!! $pemesanan->status($pemesanan->status) !!} </button>
                    @endif
                    @if ($pemesanan->status != 0)
                        @if ($pemesanan->Invoice != null)
                            <a href="{{ route('invoicePemesanan',$pemesanan->id) }}" class="btn btn-info btn-sm"><i class="fas fa-file-invoice"></i> Invoice </a>
                        @endif
                        @if ($pemesanan->cekStatusTambahan($pemesanan->id))
                            <a href="{{ route('pemesanan.cekHarga',$pemesanan->id) }}" class="btn btn-warning btn-sm"> <i class="fas fa-file-signature"></i> Setujui Pesanan Tambahanmu</a>
                        @endif
                        @if ($pemesanan->PemesananDetail->where('status_ditambahkan',1)->where('status_diajukan',2)->COUNT() > 0 )
                            <a href="{{ route('pemesanan.cekHarga',$pemesanan->id) }}" class="btn btn-warning btn-sm"><strong><i class="fas fa-tasks"></i> Cek Barang</strong></a>
                            @if ($pemesanan->cekStatusHargaUser($pemesanan->id)==0 AND $pemesanan->PemesananTambahan->where('status_ditambahkan','!=',1)->where('status_pemesanan',1)->COUNT()>0)
                                <button  data-toggle="modal" data-target="#modalSetujuiBarang"  class="btn btn-success btn-sm"><strong><i class="fas fa-clipboard-check"></i> Setujui Semua Harga</strong></button>
                            @elseif($pemesanan->cekStatusHargaUser($pemesanan->id) < COUNT($pemesanan->PemesananDetail))
                                <button data-toggle="modal" data-target="#modalSetujuiBarang"  class="btn btn-success btn-sm"><strong><i class="fas fa-clipboard-check"></i> Setujui Barang Terpilih</strong></button>
                            @endif
                        @endif
                    @endif
                    
                   
                </div>
            </div>
            <div class="card-body">
               
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><strong>Informasi Pemesanan </strong>
                                    <div wire:loading="">
                                        <i class="fas fa-circle-notch fa-spin"></i>
                                    </div>
                                </h3>
                            </div>
                            <div class="card-body">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Nama Pemesan</td>
                                            <td>:</td>
                                            <td><strong>{{ $pemesanan->User->name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>No. HP / WA</td>
                                            <td>:</td>
                                            <td><strong>081254893451</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Status Pemesanan</td>
                                            <td>:</td>
                                            <td>
                                                <strong>{!! $pemesanan->status($pemesanan->status) !!}</strong>
                                                @if ($pemesanan->Invoice != null)
                                                    @if ($pemesanan->Invoice->status == 3)
                                                        <strong><span class="badge bg-success"><i class="fas fa-file-invoice    "></i> Lunas</span></strong>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if( $pemesanan->status == 3)
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Note:</h5>
                                Kamu perlu menerima penawaran yang diberikan atau membatalkannya
                            </div>
                        @elseif( $pemesanan->status == 0)
                            <div class="callout callout-danger">
                                <h5><i class="fas fa-danger"></i> Note:</h5>
                                Pesanan dibatalkan! Keterangan: {{ $pemesanan->keterangan_batal }}
                            </div>
                        @else
                            <div class="row" style="background:#F8C25C;border-radius:20px;margin:20px 0px">
                                <div class="col-lg-4">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('img/status/stat11.png') }}" alt="" style="width:50%">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="d-flex flex-column flex-lg-row-auto " style="padding:50px">
                                        <h6 class="font-weight-bolder text-dark">Kamu masih bisa menambahkan pesananmu selagi masih disiapkan</h6>
                                            <a href="{{ route('tambahPemesanan',$pemesanan->id) }}">
                                                <button type="button" id="btn-register" class="btn btn-warning font-weight-bolder btn-md btn-pill " style="color: white;border-color:#EE9D01;background-color:#EE9D01;box-shadow: 5px 5px #00000059;">
                                                    <i class="fas fa-shopping-basket"></i>
                                                    Tambah Belanja
                                                </button>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="card card-primary card-outline">
                            <table class="table table-sm table-striped table-hover " id="servisan-table">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Per Satuan </th>
                                        <th>Qty Permintaan</th>
                                        @if (in_array($pemesanan->status, [7,8,9]))
                                            <th>Qty Diterima</th>
                                            <th>Total Harga</th>
                                        @else
                                            <th>Total Harga</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($pemesanan->PemesananDetail->groupBy('status_barang') as $items)
                                        @foreach ($items as $item)
                                            <tr class="text-center"   @if($item->status_barang == 2) style="background:rgb(248, 200, 200)" @endif>
                                                <td>{{ $i++ }}</td>
                                                <td class="text-left"><span class="badge badge-info">{{ $item->Barang->Kategori->kategori }}</span> {{ $item->Barang->nama_barang }} 
                                                    @if ($item->status_request == 2)
                                                        <span class="badge bg-success"><i class="fas fa-check-double"></i></span>
                                                    @endif
                                                </td>
                                                <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}</td>
                                                <td>{{ $item->qty }} {{ $item->Satuan->satuan }}</td>
                                                @if (in_array($pemesanan->status, [7,8,9]))
                                                    <td>{{ $item->qty_diterima }}</td>
                                                    <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty_diterima, 0, ",", ".") }}</td>
                                                @else
                                                    <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty, 0, ",", ".") }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            @if (COUNT($pemesanan->PemesananDetail)==0)
                                <div class="alert alert-info ml-3 mr-3" role="alert">
                                    <p style="margin-bottom: 0px;">Tidak ada barang yang dipesan</p>
                                </div>
                            @endif
                        </div>
                        @if (COUNT($pemesanan->PemesananTambahan )>0)
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><strong>Pesanan Tambahan </strong>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-striped table-hover " id="servisan-table" wire:ignore.self="">
                                        <thead wire:ignore="">
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Harga Per Satuan </th>
                                                <th>Qty</th>
                                                <th>Satuan</th>
                                                <th>Total Harga</th>
                                                <th>Keterangan</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @foreach ($pemesanan->PemesananTambahan as $item)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left"><span class="badge badge-info">{{ $item->Barang->Kategori->kategori }}</span> {{ $item->Barang->nama_barang }} 
                                                    @if ($item->status_request == 2)
                                                        <span class="badge bg-success"><i class="fas fa-check-double"></i></span>
                                                    @endif
                                                </td>
                                                <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->Satuan->satuan }}</td>
                                                <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty, 0, ",", ".") }}
                                                </td>
                                                <td>{{ ($item->keterangan==null)?'-':$item->keterangan }}</td>
                                                <td>
                                                    {!! $item->statusTambahan($item->status_ditambahkan) !!}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if (COUNT($pemesanan->PemesananTambahan)==0)
                                        <div class="alert alert-info" role="alert">
                                            <p style="margin-bottom: 0px;">Tidak ada barang yang dipesan</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if (COUNT($pemesanan->PemesananRequest )>0)
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><strong>Request Pemesanan </strong>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-striped table-hover " id="servisan-table">
                                        <thead>
                                            <tr>
                                                <th style="width:80px" class="text-center">No</th>
                                                <th>Nama Barang</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($pemesanan->PemesananRequest as $item)
                                                <tr>
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td>{{ $item->nama_barang }}</td>
                                                    <td class="text-center">{{ $item->qty }}</td>
                                                    <td class="text-center">{!! $item->statusRequest($item->status_request) !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if (COUNT($pemesanan->PemesananRequest)==0)
                                        <div class="alert alert-info" role="alert">
                                            <p style="margin-bottom: 0px;">Tidak ada barang yang dipesan</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <img src="{{ $pemesanan->imgStatus($pemesanan->status) }}" alt="" width="50%" style="
                                    display: block;
                                    margin-left: auto;
                                    margin-right: auto;
                                    width: 50%;">
                                    <hr>
                                <div class="timeline" style="margin: 0px">
                                    @foreach ($pemesanan->PemesananTimeLine as $item)
                                        <div class="time-label">
                                            <span class="bg-{!! $item->statusColor($item->icon) !!}">{{  \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y')  }}</span>
                                        </div>
                                        <div> 
                                            {!! $item->statusIcon($item->icon) !!}
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> {{  \Carbon\Carbon::parse($item->created_at)->translatedFormat('H:i')  }}</span>
                                                <h3 class="timeline-header"><strong>{!! $item->statusText($item->icon) !!}</strong></h3>
                                                <div class="timeline-body">
                                                    {{ $item->keterangan }}
                                                </div>
                                            </div>
                                        </div>  

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalPesananDiterima"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="pesananDiterima">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Informasi Pemesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-warning">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            Pesanan sudah diterima?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModalPesananDiterima" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-warning" type="submit" >
                            <div wire:loading.remove="" wire:target="pesananDiterima">
                                <strong style="color: white"><i class="fas fa-check-double"></i> Lanjutkan</strong>
                            </div>
                            <div wire:loading="" wire:target="pesananDiterima">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSetujuiBarang"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="setujuiBarang">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Informasi Pemesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-warning">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            Lanjutkan pesananmu dengan barang yang telah kamu setujui!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeSetujuiBarang" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-info" type="submit" >
                            <div wire:loading.remove="" wire:target="setujuiBarang">
                                <strong style="color: white"><i class="fas fa-check-double"></i> Lanjutkan</strong>
                            </div>
                            <div wire:loading="" wire:target="setujuiBarang">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalBatalkanPemesanan"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="batalkanPemesanan">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Informasi Pemesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-warning">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            Batalkan pesanan?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeBatalkanPemesanan" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-danger" type="submit" >
                            <div wire:loading.remove="" wire:target="batalkanPemesanan">
                                <strong style="color: white"><i class="fas fa-times-circle"></i>  Batalkan</strong>
                            </div>
                            <div wire:loading="" wire:target="batalkanPemesanan">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalKirimPenawaran"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="kirimPenawaran">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Informasi Pemesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-warning">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            Pastikan data harga sudah benar sebelum mengirim penawaran ke konsumen!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeKirimPenawaran" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-success" type="submit" >
                            <div wire:loading.remove="" wire:target="kirimPenawaran">
                                <strong style="color: white"><i class="fas fa-file-contract"></i>  Kirim Penawaran</strong>
                            </div>
                            <div wire:loading="" wire:target="kirimPenawaran">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div wire:poll.5000ms>
        @if (session()->has('message-success'))
            <script>
                Toast.fire({
                    icon: 'success',
                    title: '{{ session("message-success") }}'
                });
                $('#closeSetujuiBarang').click(); 
                $('#closeKirimPenawaran').click(); 
                $('#closeBatalkanPemesanan').click(); 
                $('#closeModalPesananDiterima').click(); 
            </script>
        @endif
        @if (session()->has('message-failed'))
            <script>
                Toast.fire({
                    icon: 'error',
                    title: '{{ session("message-failed") }}'
                });
            </script>
        @endif
    </div>
</div>
@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endsection
