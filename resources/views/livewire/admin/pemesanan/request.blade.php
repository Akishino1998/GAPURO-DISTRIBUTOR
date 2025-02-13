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
                    <div class="card-header">
                        <h3 class="card-title"><strong>Request Pemesanan </strong>
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-striped table-hover " id="servisan-table" wire:ignore.self="">
                            <thead wire:ignore="">
                                <tr>
                                    <th style="width:80px" class="text-center">No</th>
                                    <th>Nama Barang</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center" style="width:200px" >Aksi</th>
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
                                        <td class="text-center">
                                            @if ($item->status_request == 1)
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalVerifikasi"  wire:click="setVerifikasi({{ $item->id }})"><i class="fas fa-check-double"></i> Verifikasi</button>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalStatusBarang"  wire:click="setStatusBarang({{ $item->id }})"><i class="fas fa-trash    "></i></button>
                                            @elseif ($item->status_request == 3)
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalStatusBarang"  wire:click="setStatusBarang({{ $item->id }})"><i class="fas fa-trash-restore"></i></button>
                                            @endif
                                           
                                        </td>
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
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalVerifikasi"  wire:ignore.self>
        <div class="modal-dialog modal-lg"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="verifikasiRequest">
                    <div wire:loading wire:target="setVerifikasi">
                        <div  class="overlay"> <i class="fas fa-2x fa-sync fa-spin"></i></div>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Informasi Harga Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div  class="modal-body"  wire:loading wire:target="setVerifikasi">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                    <div class="modal-body" wire:loading.remove wire:target="setVerifikasi">
                        <div class="col-12">
                            <div class="card card-warning card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"><strong>Informasi Barang </strong>
                                    </h3>
                                </div>
                                <div class="card-body" style="display: {{ ($idBarang != '')?'none':'block' }}"  id="formSelect2">
                                    <div class="form-group" wire:ignore >
                                        <label>Pilih Barang  <span class="badge bg-primary">Wajib</span>
                                            <span class="btn btn-primary btn-sm ml-2"  data-toggle="modal" data-target="#modalTambahBarang">
                                                Tambah Baru <i class="fas fa-edit    "></i>
                                            </span>
                                        </label>
                                        <select class="form-control select2 @error('idBarang') is-invalid @enderror" id="idBarangChange" onchange="cekBarang()" style="width: 100%;" wire:model="idBarang">
                                            <option>-- Pilih Barang --</option>
                                            @foreach ($barang->groupBy('id_kategori') as $item) 
                                                @foreach ($item as $items)
                                                    <option value="{{ $items->id }}">{{ $items->Kategori->kategori }} | {{ $items->nama_barang }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        @error('idBarang') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="card-body" style="display: {{ ($idBarang == '')?'none':'block' }}" id="formPelanggan">
                                    <div class="form-group">
                                        <label for="pelanggan">Pilih Barang <span class="badge bg-primary">Wajib</span>
                                            <span class="btn btn-primary btn-sm ml-2" onclick="changeBarang()">
                                                Ganti Barang <i class="fas fa-edit    "></i>
                                            </span>
                                        </label>
                                        <div class="col-sm-12" >
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="idBarang" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if ($barangSelect != null)
                            <div class="col-sm-12">
                                <div class="card card-warning card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>Informasi Pemesanan </strong>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Qty <span class="badge bg-primary">Wajib</span></label>
                                            <input type="number" class="form-control @error('qty_request') is-invalid @enderror" wire:model="qty_request" placeholder="Qty Pemesanan">
                                            @error('qty_request') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Harga Satuan</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="text" class="form-control uang  " wire:model="harga_request" placeholder="Harga">
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
                        @endif
                    </div>
                    <div class="modal-footer"  wire:loading.remove wire:target="setVerifikasi">
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
    <div class="modal fade" id="modalTambahBarang"  wire:ignore.self>
        <div class="modal-dialog modal-lg"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="tambahBarang">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Barang Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-sm-12">
                            <label class="form-label"> Kategori <span class="badge bg-primary">Wajib</span></label>
                            <select class="form-control select2-merk"  data-placeholder="Pilih Kategori" style="width: 100%" wire:model="id_kategori" required>
                                <option value="">--- Pilih Kategori ---</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12" style="margin-bottom: 0px !important">
                            <label for="nama_part" class="form-label">Nama Barang <span class="badge bg-primary">Wajib</span></label>
                            <input class="form-control" maxlength="150" required="true" autocomplete="off" wire:model="nama_barang" type="text">
                            <p class=" mt-1">
                                Cantumkan min. 20 karakter terdiri dari jenis produk, merek, dan keterangan seperti warna, bahan, atau tipe agar mudah ditemukan.
                            </p>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="form-label"> Merk</label>
                            <select class="form-control select2-merk" data-placeholder="Pilih Merk" wire:model="id_merk">
                                <option value="">--- Pilih Merk ---</option>
                                @foreach ($merk as $item)
                                    <option value="{{ $item->id }}">{{ $item->merk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="form-label"> Satuan <span class="badge bg-primary">Wajib</span></label>
                            <select class="form-control select2-merk" data-placeholder="Pilih Satuan" wire:model="id_satuan" required>
                                <option value="">--- Pilih Satuan ---</option>
                                @foreach ($satuan as $item)
                                    <option value="{{ $item->id }}">{{ $item->satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModalTambahBarang" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-primary" type="submit" >
                            <div wire:loading.remove="" wire:target="tambahBarang">
                                <strong style="color: white"><i class="fas fa-plus"></i>  Tambah Barang Baru</strong>
                            </div>
                            <div wire:loading="" wire:target="tambahBarang">
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
                                    @if ($barangSelect->status_request != 3)
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
    <script>
        function cekBarang(){
            let idBarang = $("#idBarangChange").val();
            @this.call('cekBarang',idBarang)
        }
        function resetItem(){
            $('#changeBarang').val(null).trigger('change');
        }
    </script>
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
        @if (session()->has('dataBarang'))
            <script>
                $("#idBarang").val('{{ session("dataBarang") }}');
                $('#closeModalTambahBarang').click(); 
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
    $(document).ready(function () {
        $('.uang').mask('000.000.000.000', {
            reverse: true
        });
        $('#idBarangChange').select2();
    });
    function changeBarang(){
        @this.call('resetBarang')
        $('#idBarangChange').val(null).trigger('change');
    }
</script>

@endsection
