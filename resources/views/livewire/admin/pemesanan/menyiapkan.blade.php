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
                    <a href="{{ route('admin.pemesanan.show',$pemesanan->id) }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a>  <strong>Informasi Harga Barang</strong>
                </h3>
                <div class="card-options float-right">
                    <a href="{{ route('admin.pemesanan.menyiapkanPrint',$pemesanan->id) }}" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-print    "></i> Print </a>
                </div>    
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Per Satuan </th>
                                    <th>Qty</th>
                                    <th>Total Harga</th>
                                    <th>Keterangan</th>
                                    @if ($pemesanan->status == 4)
                                        <th>Qty Terbeli</th>
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
                                            <td>{{ $item->Penyiapan->SUM('qty') }} {{ $item->Satuan->satuan }}</td>
                                            <td>{{ ($item->Penyiapan->SUM('total_modal')==null)?"-":"Rp. " .  number_format($item->Penyiapan->SUM('total_modal'), 0, ",", ".") }}
                                            <td>
                                                <button data-toggle="modal" data-target="#modalBarangSiap" wire:click="setEditHarga({{ $item->id }})"  class="btn btn-success btn-sm"><strong><i class="fas fa-clipboard-check"></i></strong></button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @foreach ($pemesanan->PemesananDetail->where('status_barang_user',2) as $item)
                                    <tr class="text-center"   @if($item->status_barang_user == 2) style="background:rgb(248, 200, 200)" @endif>
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
                                            <td colspan="2"></td>
                                        @endif
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
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalBarangSiap"  wire:ignore.self>
        <div class="modal-dialog modal-lg"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
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
                                        <form wire:submit.prevent="editHarga">
                                            @csrf
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Harga Satuan</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp</span>
                                                        </div>
                                                        <input type="text" class="form-control uang  @error('harga_modal_total') is-invalid @enderror" wire:model="harga_modal_total" placeholder="Harga">
                                                        @error('harga_modal_total') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Qty <span class="badge bg-primary">Wajib</span></label>
                                                    <div class="input-group mb-3">
                                                        <input type="number" step=".1" class="form-control  @error('qty_pemesanan') is-invalid @enderror" wire:model="qty_pemesanan" placeholder="Qty Pemesanan">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">{{ $barangSelect->Satuan->satuan }}</span>
                                                        </div>
                                                        @error('qty_pemesanan') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <button class="btn btn-primary" type="submit" style="float: right" >
                                                <div wire:loading.remove="" wire:target="editHarga">
                                                    <strong style="color: white"><i class="fas fa-save"></i>  Simpan</strong>
                                                </div>
                                                <div wire:loading="" wire:target="editHarga">
                                                    <i class="fas fa-circle-notch fa-spin"></i>
                                                </div>
                                            </button>
                                        </form>
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
                            <div class="col-12">
                                <div class="card card-primary card-outline table-responsive">
                                    <table class="table table-sm table-striped table-hover mb-0" id="servisan-table">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Harga Satuan</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @foreach ($barangSelect->Penyiapan as $item)
                                                <tr class="text-center">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ ($item->harga_satuan==null)?"-":"Rp. " .  number_format($item->harga_satuan, 0, ",", ".") }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ ($item->total_modal==null)?"-":"Rp. " .  number_format($item->total_modal, 0, ",", ".") }}</td>
                                                    <td><button wire:click="setPembelianBarang({{ $item->id }})" data-toggle="modal" data-target="#modalHapusPembelian" class="btn btn-danger btn-sm"><i class="fas fa-trash" aria-hidden="true"></i></button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if (COUNT($barangSelect->Penyiapan)==0)
                                        <div class="alert alert-info mb-0" role="alert">
                                            <p class=" mb-0">Belum ada pembelian </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalProsesPembelian" data-dismiss="modal" >Batal</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalHapusPembelian"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="removePembelian">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-warning">
                            <h5><i class="fas fa-success"></i> Note:</h5>
                            Hapus pembelian barang?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeRemovePembelian" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-danger" type="submit" >
                            <div wire:loading.remove="" wire:target="removePembelian">
                                <strong><i class="fas fa-trash"></i>  Hapus</strong>
                            </div>
                            <div wire:loading="" wire:target="removePembelian">
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
                $('#closeModalProsesPembelian').click(); 
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
        
        @if (session()->has('message-success-remove'))
            <script>
                Toast.fire({
                    icon: 'success',
                    title: '{{ session("message-success") }}'
                });
                $('#closeRemovePembelian').click(); 
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
