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
       
                    @if ($pemesanan->status == 3)
                        <button data-toggle="modal" data-target="#modalBatalkanPemesanan" class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i> Batalkan Pemesanan</button>
                        <a href="{{ route('pemesanan.cekHarga',$pemesanan->id) }}" class="btn btn-warning btn-sm"><strong><i class="fas fa-tasks"></i> Cek Barang</strong></a>
                        @if ($pemesanan->cekStatusHargaUser($pemesanan->id)==0)
                            <button  data-toggle="modal" data-target="#modalSetujuiBarang"  class="btn btn-{{ $pemesanan->colorStatus($pemesanan->status) }} btn-sm"><strong><i class="fas fa-clipboard-check"></i> Setujui Semua Harga</strong></button>
                        @elseif($pemesanan->cekStatusHargaUser($pemesanan->id) < COUNT($pemesanan->PemesananDetail))
                            <button data-toggle="modal" data-target="#modalSetujuiBarang"  class="btn btn-{{ $pemesanan->colorStatus($pemesanan->status) }} btn-sm"><strong><i class="fas fa-clipboard-check"></i> Setujui Barang Terpilih</strong></button>
                        @endif
                    @elseif($pemesanan->status == 7)
                        <button data-toggle="modal" data-target="#modalPesananDiterima" class="btn btn-warning btn-sm"><i class="fas fa-hands"></i>  Pesanan sudah diterima?</button>
                    
                    @else
                        <button class="btn btn-{{ $pemesanan->colorStatus($pemesanan->status) }} btn-sm">{!! $pemesanan->status($pemesanan->status) !!}</button>
                    @endif
                </div>
            </div>
            <div class="card-body">
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
               
                    <div class="col-md-8">
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
                        @endif
                        <div class="card card-primary card-outline">
                            <table class="table table-sm table-striped table-hover " id="servisan-table">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Per Satuan </th>
                                        <th>Qty Permintaan</th>
                                        <th>Satuan</th>
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
                                    @foreach ($pemesanan->PemesananDetail->groupBy('status_barang_user') as $items)
                                        @foreach ($items as $item)
                                            <tr class="text-center"   @if($item->status_barang_user == 2) style="background:rgb(248, 200, 200)" @endif>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->Barang->Kategori->kategori }}</td>
                                                <td>{{ $item->Barang->nama_barang }}</td>
                                                <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->Satuan->satuan }}</td>
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
                        @if (in_array($pemesanan->status, [1,2,3]))
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><strong>Request Pemensanan </strong>
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
