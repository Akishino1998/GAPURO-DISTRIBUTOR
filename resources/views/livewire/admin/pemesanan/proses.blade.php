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
                    @if ($pemesanan->status == 1)
                        <button data-toggle="modal" data-target="#modalProsesPemesanan" class="btn btn-success btn-sm"><i class="fas fa-shopping-basket"></i> Proses Pemesanan</button>
                    @endif
                    @if ($pemesanan->status == 2)
                        <button data-toggle="modal" data-target="#modalBatalkanPemesanan" class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i> Batalkan Pemesanan</button>
                        <a href="{{ route('admin.pemesanan.setHarga',$pemesanan->id) }}" class="btn btn-info btn-sm"> <i class="fas fa-file-signature"></i> Ubah Harga</a>
                    @endif
                    @if ($pemesanan->cekStatusHarga($pemesanan->id)==0 and $pemesanan->status == 2)
                        <button data-toggle="modal" data-target="#modalKirimPenawaran" class="btn btn-success btn-sm"><i class="fas fa-file-contract"></i> Kirim Penawaran Ke Konsumen</button>
                    @endif
                    @if ($pemesanan->status == 3)
                        <button class="btn btn-info btn-sm"><i class="fas fa-file-signature"></i> Proses Penawaran Harga</button>
                    @endif
                    @if ($pemesanan->status == 4)
                        @if ($pemesanan->cekStatusPembelian($pemesanan->id) == COUNT($pemesanan->PemesananDetail->where('status_barang_user',1)))
                            <button data-toggle="modal" data-target="#modalBarangDikirim" class="btn btn-info btn-sm"><strong><i class="fas fa-truck"></i> Semua Barang Telah Dibeli, lanjutkan pengiriman?</strong></button>
                        @else
                            <button class="btn btn-success btn-sm"><strong><i class="fas fa-truck-loading"></i> Pesanan Sedang Disiapkan</strong></button>
                        @endif
                    @endif
                    @if ($pemesanan->status == 6)
                        <button class="btn btn-success btn-sm"><i class="fas fa-truck"></i> Pengiriman</button>
                        <a href="{{ route('admin.pemesanan.penerimaan',$pemesanan->id) }}" class="btn btn-warning btn-sm"><strong><i class="fas fa-people-carry"></i> Barang Diterima </strong></a>
                    @endif
                    @if ($pemesanan->status == 7)
                        <button class="btn btn-info btn-sm"><i class="fas fa-user-check"></i> Menunggu konsumen konfirmasi selesai</button>
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
                                        <strong>{!! $pemesanan->Status($pemesanan->status) !!}</strong>
                                        @if ($pemesanan->status == 2)
                                            @if ($pemesanan->cekStatusHarga($pemesanan->id)==0)
                                                <strong><span class="badge bg-info"><i class="fas fa-clipboard-check"></i> Lengkap</span></strong>
                                            @else
                                                <strong><span class="badge bg-danger"><i class="fas fa-times"></i> Belum Lengkap</span></strong>
                                            @endif
                                        @elseif ($pemesanan->status == 0)
                                            <strong><span class="badge bg-danger"><i class="fas fa-times"></i> Dibatalkan</span></strong>
                                        @endif
                                        @if ($pemesanan->cekStatusPembelian($pemesanan->id) == COUNT($pemesanan->PemesananDetail->where('status_barang_user',1)))
                                            <strong><span class="badge bg-info"><i class="fas fa-shopping-basket"></i> Lengkap</span></strong>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
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
                        @endif
                        <div class="card card-primary card-outline">
                            <table class="table table-sm table-striped table-hover " id="servisan-table" wire:ignore.self="">
                                <thead wire:ignore="">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Per Satuan </th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Keterangan</th>
                                        @if ($pemesanan->status == 4)
                                            <th>Harga Modal (Total)</th>
                                            <th>#</th>
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
                                            <td>{{ $item->Barang->Kategori->kategori }}</td>
                                            <td>{{ $item->Barang->nama_barang }}</td>
                                            <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}
                                            </td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->Satuan->satuan }}</td>
                                            <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty, 0, ",", ".") }}
                                            </td>
                                            <td>{{ ($item->keterangan==null)?'-':$item->keterangan }}</td>
                                            @if ($pemesanan->status == 4)
                                                <td>{{ ($item->harga_modal_total==null)?"-":"Rp. " .  number_format($item->harga_modal_total, 0, ",", ".") }}
                                                <td>
                                                    <button data-toggle="modal" data-target="#modalBarangSiap" wire:click="setEditHarga({{ $item->id }})"  class="btn btn-success btn-sm"><strong><i class="fas fa-clipboard-check"></i></strong></button>
                                                </td>
                                            @endif
    
                                            
                                        </tr>
                                    @endforeach
                                    @foreach ($pemesanan->PemesananDetail->where('status_barang_user',2) as $item)
                                        <tr class="text-center"   @if($item->status_barang_user == 2) style="background:rgb(248, 200, 200)" @endif>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->Barang->Kategori->kategori }}</td>
                                            <td>{{ $item->Barang->nama_barang }}</td>
                                            <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}
                                            </td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->Satuan->satuan }}</td>
                                            <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty, 0, ",", ".") }}
                                            </td>
                                            <td>{{ ($item->keterangan==null)?'-':$item->keterangan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if (COUNT($pemesanan->PemesananDetail)==0)
                            <div class="alert alert-danger" role="alert">
                                <p>Tidak Ada Datanya! </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div class="timeline" style="margin: 0px">
                                    <div class="time-label">
                                        <span class="bg-red">11 Nov 2024</span>
                                    </div>
                                    <div> 
                                        <i class="fas fa-spinner fa-spin  bg-warning"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> 18:09</span>
                                            <h3 class="timeline-header"><strong>Proses</strong></h3>
                                            <div class="timeline-body">
                                                Pemesanan dibuat dan dipesan
                                            </div>
                                        </div>
                                    </div>
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
                                <strong style="color: white"><i class="fas fa-truck-loading"></i>  Mulai pembelian</strong>
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
    <div class="modal fade" id="modalBarangSiap"  wire:ignore.self>
        <div class="modal-dialog modal-lg"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="editHarga">
                    <div wire:loading wire:target="setEditHarga">
                        <div  class="overlay"> <i class="fas fa-2x fa-sync fa-spin"></i></div>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Informasi Harga Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div  class="modal-body"  wire:loading wire:target="setEditHarga">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                    <div class="modal-body" wire:loading.remove wire:target="setEditHarga">
                        @if ($barangSelect != null)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-warning card-outline">
                                        <div class="card-body">
                                            <h6><strong>Informasi Barang</strong></h6>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>Nama Barang</td>
                                                        <td>:</td>
                                                        <td><strong><span class="badge bg-primary">{{ $barangSelect->Barang->Kategori->kategori }}</span> {{ $barangSelect->nama_barang }} </strong></td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                            <hr>
                                            <h6><strong>Informasi Pemesanan</strong></h6>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>Harga Satuan</td>
                                                        <td>:</td>
                                                        <td><strong><span class="badge bg-primary"></span> {{ "Rp. " .  number_format($barangSelect->harga_per_satuan, 0, ",", ".") }} /{{ $barangSelect->Satuan->satuan }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Pesanan</td>
                                                        <td>:</td>
                                                        <td><strong>{{ $barangSelect->qty }} {{ $barangSelect->Satuan->satuan }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Harga</td>
                                                        <td>:</td>
                                                        <td><strong><span class="badge bg-primary"></span> {{ "Rp. " .  number_format($barangSelect->harga_per_satuan*$barangSelect->qty, 0, ",", ".") }} </strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <div class="form-group">
                                                <label>Total Harga Pembelian (Modal)</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input type="text" class="form-control uang  @error('harga_modal_total') is-invalid @enderror" wire:model="harga_modal_total" placeholder="Harga">
                                                    @error('harga_modal_total') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    $('.uang').mask('000.000.000.000', {
                                                        reverse: true
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer"  wire:loading.remove wire:target="setEditBarang">
                        <button type="button" class="btn btn-secondary" id="closeModalProsesPembelian" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-primary" type="submit" >
                            <div wire:loading.remove="" wire:target="editHarga">
                                <strong style="color: white"><i class="fas fa-save"></i>  Simpan</strong>
                            </div>
                            <div wire:loading="" wire:target="editHarga">
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
                $('#closePembelianBarang').click(); 
                $('#closeModalProsesPembelian').click(); 
                $('#closeKirimPenawaran').click(); 
                $('#closeBatalkanPemesanan').click(); 
                $('#closeMulaiPengiriman').click(); 
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
