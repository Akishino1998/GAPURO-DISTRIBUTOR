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
                <h3 class="card-title"><a href="{{ route('toko.index') }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a> <strong>Pemesanan</strong></h3>
                <div class="card-option float-right">
                    <button data-toggle="modal" data-target="#modalTambahDataBarang" class="btn btn-info text-white" type="submit" style="width: 100%" > <strong><i class="fa fa-shopping-cart" aria-hidden="true"></i> Pesan Sekarang!</strong></button>
                </div>
            </div>
            <div class="card-body">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><strong>Pilih Barang</strong>
                            <div wire:loading="">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @if ($statusHarga)
                                    <div class="form-group" wire:ignore >
                                        <label>Pilih Barang </label>
                                        <select class="form-control select2 @error('idBarang') is-invalid @enderror" id="changeBarang" onchange="changeBarang()" style="width: 100%;" wire:model="idBarang">
                                            <option>-- Pilih Barang --</option>
                                            @foreach ($barangHargaFix as $item)
                                                <option value="{{ $item->id_barang }}">{{ $item->Barang->Kategori->kategori }} | {{ $item->Barang->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                        @error('idBarang') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                @else
                                    <div class="form-group" wire:ignore >
                                        <label>Pilih Barang </label>
                                        <select class="form-control select2 @error('idBarang') is-invalid @enderror" id="changeBarang" onchange="changeBarang()" style="width: 100%;" wire:model="idBarang">
                                            <option>-- Pilih Barang --</option>
                                            @foreach ($barang->groupBy('id_kategori') as $item)
                                                @foreach ($item as $items)
                                                    <option value="{{ $items->id }}">{{ $items->Kategori->kategori }} | {{ $items->nama_barang }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        @error('idBarang') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            </div>
                            @if ($namaBarang!="")
                                <div class="col-md-12">
                                    <hr style="margin:10px 0px;">
                                    <div>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th style="width: 150px">Kategori</th>
                                                    <td>{!! $kategoriBarang !!}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 150px">Nama Barang</th>
                                                    <td>{{ $namaBarang }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 150px">Keterangan</th>
                                                    <td>{{ $keteranganBarang }}</td>
                                                </tr>
                                                @if ($statusHarga)
                                                    <tr>
                                                        <th style="width: 150px">Harga</th>
                                                        <td>{{ "Rp. " .  number_format($hargaBarang->harga_jual, 0, ",", ".") }} / {{ $hargaBarang->Satuan->satuan }}</td>
                                                    </tr>
                                                @endif
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr style="margin:10px 0px;">
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Qty</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control uang  @error('qty_pemesanan') is-invalid @enderror" wire:model="qty_pemesanan" placeholder="Qty Pemesanan">
                                            <div class="input-group-append">
                                                <span class="input-group-text">{{ $satuanBarang }}</span>
                                              </div>
                                            @error('harga') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if ($statusBarang)
                                <div class="col-sm-12">
                                    <div class="callout callout-warning">
                                        <h5>Data Sama!</h5>
                                        <p>Terdapat data yang sama, hapus data sebelumnya dan masukan data baru?</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <hr>
                        @if ($statusBarang)
                            <span class="btn btn-info" wire:click='resetItem' onclick="resetItem()">
                                <div>
                                    <strong style="color: white"><i class="fas fa-eraser"></i> Reset</strong>
                                </div>
                            </span>  
                        @endif
                        <form wire:submit.prevent="tambahPesanan">
                            <button class="btn btn-primary" type="submit" style="width:100%">
                                @if ($statusBarang)
                                    <div wire:loading.remove="" wire:target="addTambahBarang">
                                        <strong style="color: white"><i class="fas fa-save"></i> Simpan Dan Lanjutkan</strong>
                                    </div>
                                @else
                                    @if ($namaBarang!="")
                                        <div wire:loading.remove="" wire:target="tambahPesanan">
                                            <strong style="color: white"><i class="fas fa-save"></i>  Simpan</strong>
                                        </div>
                                    @else
                                        <strong>Pilih barang lebih dulu</strong>
                                    @endif
                                @endif
                                <div wire:loading="" wire:target="tambahPesanan">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <table class="table table-sm table-striped table-hover " id="servisan-table" wire:ignore.self="">
                        <thead wire:ignore="">
                            <tr class="text-center">
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Nama Barang</th>
                                <th>Harga Per Satuan</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                                <th>Total Harga</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($tempBarang as $item)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->Barang->Kategori->kategori }}</td>
                                    <td>{{ $item->Barang->nama_barang }}</td>
                                    <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_jual, 0, ",", ".") }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->Satuan->satuan }}</td>
                                    <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_jual*$item->qty, 0, ",", ".") }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" wire:click="removeItemBarang({{ $item->id }})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (COUNT($tempBarang)==0)
                        <div class="alert alert-danger" role="alert">
                            <p>Tidak Ada Datanya! </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTambahDataBarang" wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <form wire:submit.prevent="tambahPemesanan">
                @csrf
                <div class="modal-content"  wire:ignore.self>
                    <div class="modal-header">
                        <h5 class="modal-title">Pesan sekarang!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-primary" role="alert">
                            Pastikan data benar, karena pesanan akan diteruskan ke admin!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModalTambahDataBarang" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success " ><i  wire:loading wire:target="tambahPemesanan" class="fas fa-circle-notch fa-spin"></i> Pesan!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function changeBarang(){
            let idBarang = $("#changeBarang").val();
            @this.call('changeBarang',idBarang)
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
                $('#changeBarang').val(null).trigger('change');
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
        @if (session()->has('message-warning'))
            <script>
                Toast.fire({
                    icon: 'warning',
                    title: '{{ session("message-warning") }}'
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
        $(document).ready(function () {
            $('.uang').mask('000.000.000.000', {
                reverse: true
            });
            $('#changeBarang').select2();
        });
    </script>
@endsection
