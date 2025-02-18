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
    th{
        vertical-align:middle !important
    }
</style>
@endsection
<div>
    <div class="content px-3 pt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a href="{{ route('admin.pemesanan.show',$pemesanan->id) }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a>  <strong>Informasi Penerimaan Barang</strong>
                </h3>
                <div class="card-option float-right">
                    @if ($pemesanan->cekStatusPenerimaan($pemesanan->id) && $pemesanan->status == 5 && $pemesanan->tgl_selesai_konsumen != null)
                        <button data-toggle="modal" data-target="#modalPenerimaan" class="btn btn-success btn-sm"><strong><i class="fas fa-user-check"></i> Semua barang sudah sesuai?</strong></button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <table class="table table-sm table-striped table-hover " id="servisan-table" >
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama Barang</th>
                                <th rowspan="2">Harga Per Satuan </th>
                                <th rowspan="2">Qty Permintaan</th>
                                <th rowspan="2">Satuan</th>
                                <th colspan="2">Verifikasi Qty</thco>
                                <th rowspan="2">#</th>
                            </tr>
                            <tr class="text-center">
                                <th>Admin</th>
                                <th>Konsumen</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($pemesanan->PemesananDetail->where('status_tersedia',2) as $item)
                            <tr class="text-center" @if($item->qty_diterima == $item->qty_diterima_user && $item->qty_diterima != null && $item->qty_diterima_user != null) style="background:rgb(207 248 200)" @endif>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-info">{{ $item->Barang->Kategori->kategori }}</span> {{ $item->Barang->nama_barang }}</td>
                                <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->Satuan->satuan }}</td>
                                <td>{{ $item->qty_diterima }}</td>
                                <td>{{ $item->qty_diterima_user }}</td>
                                <td>
                                    <button class="btn btn-{{ ($item->qty_diterima==null)?'warning':'success' }} btn-sm" data-toggle="modal" data-target="#modalStatusBarang"  wire:click="setEditHarga({{ $item->id }})"><i class="fas fa-tasks"></i></button>
                                </td>
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
    <div class="modal fade" id="modalStatusBarang"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="editStatusBarang">
                    <div wire:loading wire:target="setStatusBarang">
                        <div  class="overlay"> <i class="fas fa-2x fa-sync fa-spin"></i></div>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Status Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div  class="modal-body"  wire:loading wire:target="setStatusBarang">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                    <div class="modal-body" wire:loading.remove wire:target="setStatusBarang">
                        @if ($barangSelect != null)
                            <div class="row">
                                <div class="col-12">
                                    <div class="callout callout-info">
                                        <h5><i class="fas fa-info"></i> Note:</h5>
                                        Pastikan barang yang diterima sesuai?
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Qty <span class="badge bg-primary">Wajib</span></label>
                                        <div class="input-group mb-3">
                                            <input type="number" step=".01" class="form-control  @error('qty_pesanan') is-invalid @enderror" wire:model="qty_pesanan" placeholder="Qty Pemesanan">
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ $satuan }}</span>
                                              </div>
                                            @error('qty_pesanan') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer"  wire:loading.remove wire:target="setStatusBarang">
                        <button type="button" class="btn btn-secondary" id="closeModalEditStatus" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-success" type="submit" >
                            <div wire:loading.remove="" wire:target="editStatusBarang">
                                <strong style="color: white"><i class="fas fa-hands"></i>  Simpan</strong>
                            </div>
                            <div wire:loading="" wire:target="editStatusBarang">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPenerimaan"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="penerimaanBarang">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Status Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="callout callout-info">
                                    <h5><i class="fas fa-info"></i> Note:</h5>
                                    Barang sudah diterima semua oleh konsumen?
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModalPenerimaanBarang" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-success" type="submit" >
                            <div wire:loading.remove="" wire:target="penerimaanBarang">
                                <strong style="color: white"><i class="fas fa-user-check"></i>Simpan</strong>
                            </div>
                            <div wire:loading="" wire:target="penerimaanBarang">
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
                $('#closeModalEditStatus').click(); 
                $('#closeModalPenerimaanBarang').click(); 
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
