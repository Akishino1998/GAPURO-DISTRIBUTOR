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
            </div>
            <div class="card-body">
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
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($pemesanan->PemesananDetail as $item)
                            <tr class="text-center"   @if($item->status_barang == 2) style="background:rgb(248, 200, 200)" @endif>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->Barang->Kategori->kategori }}</td>
                                <td>{{ $item->Barang->nama_barang }}</td>
                                <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}
                                </td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->Satuan->satuan }}</td>
                                <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty, 0, ",", ".") }}
                                </td>
                                <td>{{ ($item->keterangan==null)?'-':$item->keterangan }}</td>
                                <td>
                                    @if ($item->status_barang == 1)
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEditHarga"  wire:click="setEditHarga({{ $item->id }})"><i class="fas fa-edit    "></i> Ubah Harga</button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalStatusBarang"  wire:click="setStatusBarang({{ $item->id }})"><i class="fas fa-trash    "></i></button>
                                    @else
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalStatusBarang"  wire:click="setStatusBarang({{ $item->id }})"><i class="fas fa-trash-restore"></i></button>
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
    <div class="modal fade" id="modalEditHarga"  wire:ignore.self>
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
                                            <div class="form-group">
                                                <label>Harga</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input type="text" class="form-control uang  @error('harga') is-invalid @enderror" wire:model="harga" placeholder="Harga">
                                                    @error('harga') <span class="error invalid-feedback">{{ $message }}</span> @enderror
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
                        <button type="button" class="btn btn-secondary" id="closeModalEditBarang" data-dismiss="modal" >Batal</button>
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
                                    @if ($barangSelect->status_barang == 1)
                                        <div class="callout callout-info">
                                            <h5><i class="fas fa-info"></i> Note:</h5>
                                            Barang tidak tersedia?
                                        </div>
                                    @else
                                        <div class="callout callout-info">
                                            <h5><i class="fas fa-info"></i> Note:</h5>
                                            Barang tersedia?
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer"  wire:loading.remove wire:target="setStatusBarang">
                        <button type="button" class="btn btn-secondary" id="closeModalEditStatus" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-primary" type="submit" >
                            <div wire:loading.remove="" wire:target="editStatusBarang">
                                <strong style="color: white"><i class="fas fa-save"></i>  Simpan</strong>
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
    <div wire:poll.5000ms>
        @if (session()->has('message-success'))
            <script>
                Toast.fire({
                    icon: 'success',
                    title: '{{ session("message-success") }}'
                });
                $('#closeModalEditBarang').click(); 
                $('#closeModalEditStatus').click(); 
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
