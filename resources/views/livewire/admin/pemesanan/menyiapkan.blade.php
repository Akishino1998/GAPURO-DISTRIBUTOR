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
                    <table class="table table-sm table-striped table-hover " id="servisan-table">
                        <thead>
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
                                    <td>{{ $item->Barang->nama_barang }} 
                                        @if ($item->status_request == 2)
                                            <span class="badge bg-success"><i class="fas fa-check-double"></i></span>
                                        @endif
                                    </td>
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
                                                <p class=" mt-1">
                                                    Total modal yang digunakan untuk pembelian barang tersebut (qty x harga per qty)
                                                </p>
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
