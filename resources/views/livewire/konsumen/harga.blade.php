@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection
<div>

    <div class="content px-3 pt-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="card-title">
                    <h5 style="margin-bottom: 0px"><strong>Daftar Harga Konsumen {{ $konsumen->name }}</strong></h5>
                </div>
                <div class="card-option">
                    <a class="btn btn-primary btn-sm float-right" href="{{ route('konsumen.setHarga',$konsumen->id) }}"><i class="fas fa-user-plus    "></i> Tambah Data Harga Barang </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="input-group input-group">
                        <input type="search" class="form-control form-control" placeholder="Cari Barang" wire:model="search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <button class="btn btn-info btn-sm"style="width: 100%"><b><i class="fas fa-users"></i> Total Barang : {{ count($barangFix) }}</b> </button>
                        </div>
                    </div>
                    <table class="table" id="tokoPelanggans-table">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($barangFix as $item)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->Barang->Kategori->kategori }}</td>
                                    <td>{{ $item->Barang->nama_barang }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->Satuan->satuan }}</td>
                                    <td>{{ "Rp. " .  number_format($item->harga_jual, 0, ",", ".") }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalEditBarang"  wire:click="setEditBarang({{ $item->id }})"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                            <button class="btn btn-danger btn-sm" wire:click="removeItemBarang({{ $item->id }})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (COUNT($barangFix)>0)
                        @if (COUNT($barangFix )>=$limitPerPage)
                            <div>
                                <div class="d-flex justify-content-center mb-3">
                                    <button class="btn btn-primary btn-sm" wire:loading.flex wire:target="loadMore"><span><b><i class="fas fa-circle-notch fa-spin "></i> Loading</b></span></button>
                                    <button class="btn btn-primary btn-sm" wire:click="loadMore()"  wire:loading.remove wire:target="loadMore"><b>Lihat lainnya</b></button>
                                </div>
                            </div>
                        @endif
                    @else
                        <div wire:loading.remove>
                            <div class="alert alert-info" role="alert">
                                <p>Belum ada data! </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalEditBarang"  wire:ignore.self>
        <div class="modal-dialog modal-lg"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="simpanDataBarang">
                    <div wire:loading wire:target="setEditBarang">
                        <div  class="overlay"> <i class="fas fa-2x fa-sync fa-spin"></i></div>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Informasi Harga Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div  class="modal-body"  wire:loading wire:target="setEditBarang">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                    <div class="modal-body" wire:loading.remove wire:target="setEditBarang">
                        @if ($barangSelect != null)
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group" wire:ignore >
                                        <label>Data Barang </label>
                                        <input type="text" class="form-control @error('namaBarang') is-invalid @enderror" wire:model="namaBarang" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Qty</label>
                                        <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty" wire:model="qty" placeholder="-- Qty --" autocomplete="off" >
                                        @error('qty') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Satuan</label>
                                        <select class="form-control @error('qty') is-invalid @enderror" style="width: 100%;" wire:model="idSatuan">
                                            <option>-- Pilih Satuan --</option>
                                            @foreach ($satuan as $item)
                                                <option value="{{ $item->id }}">{{ $item->satuan }}</option>
                                            @endforeach
                                        </select>
                                        @error('qty') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
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
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <input type="text" class="form-control " id="keterangan" wire:model="keterangan" placeholder="-- Keterangan --" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        @endif
                    
                    </div>
                    <div class="modal-footer"  wire:loading.remove wire:target="setEditBarang">
                        <button type="button" class="btn btn-secondary" id="closeModalEditBarang" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-primary" type="submit" >
                            <div wire:loading.remove="" wire:target="simpanDataBarang">
                                <strong style="color: white"><i class="fas fa-save"></i>  Simpan</strong>
                            </div>
                            <div wire:loading="" wire:target="simpanDataBarang">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div>
        @if (session()->has('message-success'))
            <script>
                Toast.fire({
                    icon: 'success',
                    title: '{{ session("message-success") }}'
                });
                $('#closeModalEditBarang').click(); 
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        $(document).ready(function () {
            $('.uang').mask('000.000.000.000', {
                reverse: true
            });
        });
    </script>
@endsection