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
                    <a href="{{ route('pemesanan.show',$pemesanan->id) }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a>  <strong>Informasi Harga Barang</strong>
                </h3>
                <div class="card-option float-right">
                    @if ($pemesanan->status == 5)
                        @if ($pemesanan->tgl_selesai_konsumen == null)
                            <button data-toggle="modal" data-target="#modalPenerimaan" class="btn btn-success btn-sm"><strong><i class="fas fa-user-check"></i> Semua Barang Yang Diterima Sesuai?</strong></button>
                        @else
                            <button class="btn btn-warning btn-sm"><strong><i class="fas fa-user-clock"></i> Admin sedang verifikasi pemesananmu</strong></button>
                        @endif
                    @elseif($pemesanan->status == 7)
                        <button data-toggle="modal" data-target="#modalPesananDiterima" class="btn btn-warning btn-sm"><i class="fas fa-hands"></i>  Pesanan sudah diterima?</button>
                    @else
                        <button class="btn btn-success btn-sm"><strong><i class="fas fa-tasks"></i> Pemesanan Sudah Selesai</strong></button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <table class="table table-sm table-striped table-hover " id="servisan-table" wire:ignore.self="">
                        <thead wire:ignore="">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Harga Per Satuan </th>
                                <th>Qty Permintaan</th>
                                <th>Satuan</th>
                                <th>Qty Diterima</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($pemesanan->PemesananDetail->where('status_tersedia',2) as $item)
                            <tr class="text-center"  @if($item->qty_diterima_user != null) style="background:rgb(207 248 200)" @endif>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-info">{{ $item->Barang->Kategori->kategori }}</span> {{ $item->Barang->nama_barang }}</td>
                                <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->Satuan->satuan }}</td>
                                <td>{{ $item->qty_diterima_user }}</td>
                                <td>
                                    @if ($pemesanan->status == 5)
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalStatusBarang"  wire:click="setEditHarga({{ $item->id }})"><i class="fas fa-check-double"></i></button>
                                    @endif
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
                                    Semua pesanan yang diterima telah sesuai!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModalPenerimaanBarang" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-success" type="submit" >
                            <div wire:loading.remove="" wire:target="penerimaanBarang">
                                <strong style="color: white"><i class="fas fa-user-check"></i> Selesai</strong>
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
