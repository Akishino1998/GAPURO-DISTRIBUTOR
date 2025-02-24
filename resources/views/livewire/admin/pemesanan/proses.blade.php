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
                    <a href="{{ route('admin.pemesanan.index') }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a>  <strong>Informasi Pemesanan</strong>
                </h3>
                <div class="card-options float-right">
                    @if (auth()->user()->id_role == 1)
                        @if ($pemesanan->Invoice != null)
                            <a href="{{ route('admin.pemesanan.invoice',$pemesanan->id) }}" class="btn btn-info btn-sm"><i class="fas fa-file-invoice"></i> Invoice 
                                @if ($pemesanan->Invoice->status == 1)
                                    <span class="badge bg-secondary"><i class="fas fa-spinner fa-spin"></i> Belum Diproses</span>
                                @elseif ($pemesanan->Invoice->status == 2)
                                    <span class="badge bg-primary"><i class="fas fa-file-invoice"></i> Terbit</span>
                                @elseif ($pemesanan->Invoice->status == 3)
                                    <span class="badge bg-success">Lunas</span>
                                @endif
                            </a>
                        @endif
                        @if ($pemesanan->status == 1)
                            <button data-toggle="modal" data-target="#modalProsesPemesanan" class="btn btn-success btn-sm"><i class="fas fa-shopping-basket"></i> Proses Pemesanan</button>
                        @endif
                        @if ($pemesanan->status == 2)
                            <button data-toggle="modal" data-target="#modalBatalkanPemesanan" class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i> Batalkan Pemesanan</button>
                            @if (COUNT($pemesanan->PemesananDetail)!=0 AND COUNT($pemesanan->PemesananDetail->where('tgl_harga_acc'))!=COUNT($pemesanan->PemesananDetail))
                                <a href="{{ route('admin.pemesanan.setHarga',$pemesanan->id) }}" class="btn btn-info btn-sm"> <i class="fas fa-file-signature"></i> Ubah Harga</a>
                            @endif
                        @endif
                        @if ($pemesanan->cekStatusRequest($pemesanan->id))
                            <a href="{{ route('admin.pemesanan.request',$pemesanan->id) }}" class="btn btn-warning btn-sm"> <i class="fas fa-file-signature"></i> Verifikasi Request</a>
                        @endif
                        @if ($pemesanan->cekStatusTambahan($pemesanan->id))
                            <a href="{{ route('admin.pemesanan.setHarga',$pemesanan->id) }}" class="btn btn-warning btn-sm"> <i class="fas fa-file-signature"></i> Verifikasi Tambahan</a>
                        @endif
                        
                        @if ($pemesanan->cekStatusHarga($pemesanan->id)==0 and $pemesanan->status == 2)
                            <button data-toggle="modal" data-target="#modalKirimPenawaran" class="btn btn-success btn-sm"><i class="fas fa-file-contract"></i> Kirim Penawaran Ke Konsumen</button>
                        @endif
                        @if ($pemesanan->status == 3)
                            <button class="btn btn-info btn-sm"><i class="fas fa-file-signature"></i> Proses Penawaran Harga</button>
                        @endif
                        @if ($pemesanan->status == 4)
                            @if ($pemesanan->cekStatusRequest($pemesanan->id)==null)
                                @if ($pemesanan->cekStatusPembelian($pemesanan->id) == COUNT($pemesanan->PemesananDetail->where('status_barang_user',1)))
                                    <button data-toggle="modal" data-target="#modalBarangDikirim" class="btn btn-info btn-sm"><strong><i class="fas fa-truck"></i> Semua Barang Telah Dibeli, lanjutkan pengiriman?</strong></button>
                                @else
                                    <a href="{{ route('admin.pemesanan.menyiapkan',$pemesanan->id) }}" class="btn btn-success btn-sm"><strong><i class="fas fa-truck-loading"></i> Siapkan Pesanan</strong></a>
                                @endif
                            @endif
                            
                        @endif
                        @if ($pemesanan->status == 6)
                            <button class="btn btn-success btn-sm"><i class="fas fa-truck"></i> Pengiriman</button>
                            <button data-toggle="modal" data-target="#modalBarangSampai" class="btn btn-primary btn-sm"><i class="fas fa-truck-loading"></i> Barang Sudah Sampai</button>
                        @endif
                        @if ($pemesanan->status == 5)
                            <a href="{{ route('admin.pemesanan.penerimaan',$pemesanan->id) }}" class="btn btn-warning btn-sm"><strong><i class="fas fa-tasks"></i>  Verifikasi Pemesanan </strong></a>
                  
                        @endif
                        @if ($pemesanan->status == 7)
                            <button class="btn btn-info btn-sm"><i class="fas fa-user-check"></i> Menunggu konsumen konfirmasi selesai</button>
                        @endif
                      
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8 col-md-12">
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
                                                <strong>{!! $pemesanan->Status($pemesanan->status) !!}</strong>
                                                @if ($pemesanan->status == 2)
                                                    @if ($pemesanan->cekStatusHarga($pemesanan->id)==0)
                                                        <strong><span class="badge bg-info"><i class="fas fa-clipboard-check"></i> Lengkap</span></strong>
                                                    @else
                                                        <strong><span class="badge bg-danger"><i class="fas fa-times"></i> Belum Lengkap</span></strong>
                                                    @endif
                                                @endif
                                                @if ($pemesanan->cekStatusHarga($pemesanan->id)==0)
                                                    @if ($pemesanan->cekStatusPembelian($pemesanan->id) == COUNT($pemesanan->PemesananDetail->where('status_barang_user',1)))
                                                        <strong><span class="badge bg-info"><i class="fas fa-shopping-basket"></i> Lengkap</span></strong>
                                                    @endif
                                                @endif
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
                        @if ( $pemesanan->status == 2)
                            @if ($pemesanan->cekStatusHarga($pemesanan->id)==0 )
                                <div class="callout callout-info">
                                    <h5><i class="fas fa-info"></i> Note:</h5>
                                    Data Harga Lengkap, kirim ke konsumenmu segera!
                                </div>
                            @else
                                <div class="callout callout-warning">
                                    <h5><i class="fas fa-info"></i> Note:</h5>
                                    Lengkapi data harga sebelum dikirim ke konsumen!
                                </div>
                            @endif
                        @elseif( $pemesanan->status == 3)
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Note:</h5>
                                Menunggu konsumen menerima penawaran harga yang diberikan!
                            </div>
                        @elseif( $pemesanan->status == 0)
                            <div class="callout callout-danger">
                                <h5><i class="fas fa-danger"></i> Note:</h5>
                                Pesanan dibatalkan! Keterangan: {{ $pemesanan->keterangan_batal }}
                            </div>
                        @endif
                     
                        <div class="card card-primary card-outline table-responsive">
                            <table class="table table-sm table-striped table-hover " id="servisan-table">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Satuan </th>
                                        <th>Qty</th>
                                        <th>Total Harga</th>
                                        <th>Keterangan</th>
                                        @if ($pemesanan->status == 4)
                                            <th>Harga Modal (Total)</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($pemesanan->PemesananDetail->where('status_barang_user',1) as $item)
                                        <tr class="text-center"   @if($item->status_tersedia == 2) style="background:rgb(207 248 200)" @endif>
                                            <td>{{ $i++ }}</td>
                                            <td><span class="badge badge-info">{{ $item->Barang->Kategori->kategori }}</span> {{ $item->Barang->nama_barang }} 
                                                @if ($item->status_request == 2)
                                                    <span class="badge bg-success"><i class="fas fa-check-double"></i></span>
                                                @endif
                                            </td>
                                            <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}
                                            </td>
                                            <td>{{ $item->qty }} {{ $item->Satuan->satuan }}</td>
                                            <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty, 0, ",", ".") }}
                                            </td>
                                            <td>{{ ($item->keterangan==null)?'-':$item->keterangan }}</td>
                                            @if ($pemesanan->status == 4)
                                                <td>{{ ($item->harga_modal_total==null)?"-":"Rp. " .  number_format($item->harga_modal_total, 0, ",", ".") }}
                                            @endif
                                        </tr>
                                    @endforeach
                                    @foreach ($pemesanan->PemesananDetail->where('status_barang_user',2) as $item)
                                        <tr class="text-center"  @if($item->status_barang_user == 2) style="background:rgb(248, 200, 200)" @endif>
                                            <td>{{ $i++ }}</td>
                                            <td><span class="badge badge-info">{{ $item->Barang->Kategori->kategori }}</span> {{ $item->Barang->nama_barang }} 
                                                @if ($item->status_request == 2)
                                                    <span class="badge bg-success"><i class="fas fa-check-double"></i></span>
                                                @endif
                                            </td>
                                            <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}
                                            </td>
                                            <td>{{ $item->qty }} {{ $item->Satuan->satuan }}</td>
                                            <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty, 0, ",", ".") }}
                                            </td>
                                            <td>{{ ($item->keterangan==null)?'-':$item->keterangan }}</td>
                                            @if ($pemesanan->status == 4)
                                                <td>{{ ($item->harga_modal_total==null)?"-":"Rp. " .  number_format($item->harga_modal_total, 0, ",", ".") }}
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if (COUNT($pemesanan->PemesananDetail)==0)
                                <div class="alert alert-info ml-3 mr-3" role="alert">
                                    <p style="margin-bottom: 0px;">Tidak ada barang yang dipesan</p>
                                </div>
                            @endif
                        </div>
                        @if (COUNT($pemesanan->PemesananTambahan)>0)
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><strong>Pemesanan Tambahan </strong>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-striped table-hover " id="servisan-table">
                                        <thead>
                                            <tr>
                                                <th style="width:80px" class="text-center">No</th>
                                                <th>Nama Barang</th>
                                                <th class="text-center">Harga Satuan</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Total Harga</th>
                                                <th class="text-center">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($pemesanan->PemesananTambahan as $item)
                                                <tr class="text-center" >
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-left">{{ $item->nama_barang }}</td>
                                                    <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}
                                                    </td>
                                                    <td>{{ $item->qty }} {{ $item->Satuan->satuan }}</td>
                                                    <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty, 0, ",", ".") }}
                                                    </td>
                                                    <td class="text-center">{!! $item->statusTambahan($item->status_ditambahkan) !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if (COUNT($pemesanan->PemesananTambahan)==0)
                                        <div class="alert alert-info" role="alert">
                                            <p style="margin-bottom: 0px;">Tidak ada barang yang direquest</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if (COUNT($pemesanan->PemesananRequest)>0)
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
                                            <p style="margin-bottom: 0px;">Tidak ada barang yang direquest</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-4 col-md-12">
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
    <div class="modal fade" id="modalBarangDikirim"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="mulaiPengiriman">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Informasi Pemesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-warning">
                            <h5><i class="fas fa-success"></i> Note:</h5>
                            Barang sudah lengkap dan mulai pengiriman?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeMulaiPengiriman" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-info" type="submit" >
                            <div wire:loading.remove="" wire:target="mulaiPengiriman">
                                <strong style="color: white"><i class="fas fa-truck-loading"></i>  Mulai Pengiriman</strong>
                            </div>
                            <div wire:loading="" wire:target="mulaiPengiriman">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalProsesPemesanan"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="mulaiPembelian">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Informasi Pemesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-warning">
                            <h5><i class="fas fa-success"></i> Note:</h5>
                            Mulai proses pembelian barang?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closePembelianBarang" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-success" type="submit" >
                            <div wire:loading.remove="" wire:target="mulaiPembelian">
                                <strong style="color: white"><i class="fas fa-shopping-basket"></i>  Mulai pembelian</strong>
                            </div>
                            <div wire:loading="" wire:target="mulaiPembelian">
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
                        <div class="form-group" style="margin-bottom: 0px !important">
                            <label for="nama_part" class="form-label">Keterangan <span class="badge bg-primary">Wajib</span></label>
                            <input class="form-control" required="true" autocomplete="off" wire:model="keterangan_batal" type="text">
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
    <div class="modal fade" id="modalBarangSampai"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="barangSampai">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Informasi Pemesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-warning">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            Barang sudah sampai? Verifikasi pemesanan setelah konfirmasi barang sampai.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModalBarangSampai" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-success" type="submit" >
                            <div wire:loading.remove="" wire:target="barangSampai">
                                <strong style="color: white"><i class="fas fa-truck-loading"></i>  Sudah Sampai</strong>
                            </div>
                            <div wire:loading="" wire:target="barangSampai">
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
                $('#closePembelianBarang').click(); 
                $('#closeModalProsesPembelian').click(); 
                $('#closeKirimPenawaran').click(); 
                $('#closeBatalkanPemesanan').click(); 
                $('#closeMulaiPengiriman').click(); 
                $('#closeModalBarangSampai').click(); 
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
