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
                <div class="card-options float-right">
                    @if ($pemesanan->cekStatusHargaUser($pemesanan->id)==0 AND $pemesanan->PemesananTambahan->where('status_ditambahkan','!=',1)->where('status_pemesanan',1)->COUNT()>0)
                        <button  data-toggle="modal" data-target="#modalSetujuiBarang"  class="btn btn-{{ $pemesanan->colorStatus($pemesanan->status) }} btn-sm"><strong><i class="fas fa-clipboard-check"></i> Setujui Semua Harga</strong></button>
                    @elseif($pemesanan->cekStatusHargaUser($pemesanan->id) < COUNT($pemesanan->PemesananDetail) AND $pemesanan->PemesananDetail->where('status_ditambahkan',1)->COUNT()>0)
                        <button data-toggle="modal" data-target="#modalSetujuiBarang"  class="btn btn-{{ $pemesanan->colorStatus($pemesanan->status) }} btn-sm"><strong><i class="fas fa-clipboard-check"></i> Setujui Barang Terpilih</strong></button>
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
                                <th>Qty</th>
                                <th>Total Harga</th>
                                <th>Keterangan</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($pemesanan->PemesananDetail->where('status_barang',3) as $item)
                                <tr class="text-center" >
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-left"><span class="badge badge-info">{{ $item->Barang->Kategori->kategori }}</span> {{ $item->Barang->nama_barang }} 
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
                                    <td>
                                        @if ($item->status_diajukan == 1)
                                            <span class="badge badge-info"><i class="fas fa-spinner fa-spin"></i> Pengajuan</span>
                                        @else
                                            @if ($item->status_ditambahkan == 1)
                                                @if ($item->status_barang_user == 1)
                                                    @if ($item->tgl_harga_acc == null)
                                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalStatusBarang"  wire:click="setStatusBarang({{ $item->id }},1,1)"><i class="far fa-check-square"></i></button>
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalStatusBarang"  wire:click="setStatusBarang({{ $item->id }},1,2)"><i class="far fa-times-circle"></i></button>
                                                    @else
                                                        @if ($item->tgl_harga_acc != null)
                                                            <button class="btn btn-success btn-sm"><i class="fas fa-check-double    "></i> Disetujui</button>
                                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalResetStatusBarang"  wire:click="setResetStatusBarang({{ $item->id }},1,2)"><i class="fas fa-exchange-alt"></i></button>
                                                        @else
                                                            <button class="btn btn-danger btn-sm"><i class="fas fa-times   "></i> Ditolak</button>
                                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalResetStatusBarang" wire:click="setResetStatusBarang({{ $item->id }},1,2)"><i class="fas fa-exchange-alt"></i></button>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if ($item->tgl_harga_acc != null)
                                                        <button class="btn btn-success btn-sm"><i class="fas fa-check-double    "></i> Disetujui</button>
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalResetStatusBarang"  wire:click="setResetStatusBarang({{ $item->id }},1,2)"><i class="fas fa-exchange-alt"></i></button>
                                                    @else
                                                        <button class="btn btn-danger btn-sm"><i class="fas fa-times   "></i> Ditolak</button>
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalResetStatusBarang" wire:click="setResetStatusBarang({{ $item->id }},1,2)"><i class="fas fa-exchange-alt"></i></button>
                                                    @endif
                                                @endif
                                            @else
                                                @if ($item->tgl_harga_acc != null)
                                                    <span class="badge bg-success"><i class="fas fa-file-signature"></i> Disetujui</span>
                                                @else
                                                    <span class="badge bg-danger"><i class="fas fa-times"></i> Ditolak</span>
                                                @endif
                                            @endif
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
                @if (COUNT($pemesanan->PemesananTambahan)>0)
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                <strong>
                                    Pesanan Tambahan
                                </strong>
                            </div>
                            <div class="card-options float-right">
                                @if ($pemesanan->PemesananTambahan->where('status_ditambahkan','!=',1)->where('status_pemesanan',1)->where('status_diajukan',2)->COUNT()>0)
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalAddPesananTambahan" > <i class="fas fa-file-signature"></i> Setujui Pesanan Tambahan</button>
                                @endif
                            </div>
                        </div>
                        <table class="table table-sm table-striped table-hover " id="servisan-table" wire:ignore.self="">
                            <thead wire:ignore="">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Per Satuan </th>
                                    <th>Qty</th>
                                    <th>Total Harga</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($pemesanan->PemesananTambahan as $item)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-left"><span class="badge badge-info">{{ $item->Barang->Kategori->kategori }}</span> {{ $item->Barang->nama_barang }} 
                                        @if ($item->status_request == 2)
                                            <span class="badge bg-success"><i class="fas fa-check-double"></i></span>
                                        @endif
                                    </td>
                                    <td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}</td>
                                    <td>{{ $item->qty }} {{ $item->Satuan->satuan }}</td>
                                    <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_per_satuan*$item->qty, 0, ",", ".") }}
                                    </td>
                                    <td>
                                        @if ($item->status_diajukan==1)
                                        <span class="badge bg-info btn-sm"><i class="fas fa-spinner fa-spin"></i> Admin sedang verifikasi</span>
                                        @else
                                            @if ($item->status_pemesanan == 1)
                                                @if ($item->status_ditambahkan == 1)
                                                    @if ($item->status_diajukan==1)
                                                        <span class="badge bg-info btn-sm"><i class="fas fa-spinner fa-spin"></i> Admin sedang verifikasi</span>
                                                    @else
                                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalStatusBarang"  wire:click="setStatusBarang({{ $item->id }},2,1)"><i class="far fa-check-square"></i></button>
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalStatusBarang"  wire:click="setStatusBarang({{ $item->id }},2,2)"><i class="far fa-times-circle"></i></button>
                                                    @endif
                                                @elseif ($item->status_ditambahkan == 2)
                                                    <button class="btn btn-success btn-sm"><i class="fas fa-check-double    "></i> Disetujui</button>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalResetStatusBarang"  wire:click="setResetStatusBarang({{ $item->id }},2,2)"><i class="fas fa-exchange-alt"></i></button>
                                                @else
                                                    <button class="btn btn-danger btn-sm"><i class="fas fa-times   "></i> Ditolak</button>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalResetStatusBarang" wire:click="setResetStatusBarang({{ $item->id }},2,2)"><i class="fas fa-exchange-alt"></i></button>
                                                @endif
                                            @else
                                                @if ($item->status_ditambahkan == 2)
                                                    <span class="badge bg-success"><i class="fas fa-file-signature"></i> Ditambahkan</span>
                                                @else
                                                    <span class="badge bg-danger"><i class="fas fa-times"></i> Ditolak</span>
                                                @endif
                                            @endif
                                        @endif
                                       
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if (COUNT($pemesanan->PemesananTambahan)==0)
                        <div class="alert alert-danger" role="alert">
                            <p>Tidak Ada Datanya! </p>
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddPesananTambahan"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="addPesananTambahan">
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
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            Konfirmasi pesanan tambahan
                        </div>
                    </div>
                    <div class="modal-footer" >
                        <button type="button" class="btn btn-secondary" id="closeModalAddPesananTambahan" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-primary" type="submit" >
                            <div wire:loading.remove="" wire:target="addPesananTambahan">
                                <strong style="color: white"><i class="fas fa-save"></i>  Simpan</strong>
                            </div>
                            <div wire:loading="" wire:target="addPesananTambahan">
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
                                    @if ($stat == 1)
                                        @if ($barangSelect->status_barang_user == 1)
                                            <div class="callout callout-info">
                                                <h5><i class="fas fa-info"></i> Note:</h5>
                                                Harga tidak cocok?
                                            </div>
                                        @else
                                            <div class="callout callout-info">
                                                <h5><i class="fas fa-info"></i> Note:</h5>
                                                Harga cocok?
                                            </div>
                                        @endif
                                    @else
                                        @if ($setujui == 2)
                                            <div class="callout callout-info">
                                                <h5><i class="fas fa-info"></i> Note:</h5>
                                                Harga tidak cocok?
                                            </div>
                                        @else
                                            <div class="callout callout-info">
                                                <h5><i class="fas fa-info"></i> Note:</h5>
                                                Harga cocok?
                                            </div>
                                        @endif
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
    <div class="modal fade" id="modalResetStatusBarang"  wire:ignore.self>
        <div class="modal-dialog"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <form wire:submit.prevent="resetStatusBarang">
                    <div wire:loading wire:target="setResetStatusBarang">
                        <div  class="overlay"> <i class="fas fa-2x fa-sync fa-spin"></i></div>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Status Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div  class="modal-body"  wire:loading wire:target="setResetStatusBarang">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                    <div class="modal-body" wire:loading.remove wire:target="setResetStatusBarang">
                        @if ($barangSelect != null)
                            <div class="row">
                                <div class="col-12">
                                    <div class="callout callout-info">
                                        <h5><i class="fas fa-info"></i> Note:</h5>
                                        Reset Status
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer"  wire:loading.remove wire:target="setResetStatusBarang">
                        <button type="button" class="btn btn-secondary" id="closeModalresetStatus" data-dismiss="modal" >Batal</button>
                        <button class="btn btn-primary" type="submit" >
                            <div wire:loading.remove="" wire:target="resetStatusBarang">
                                <strong style="color: white"><i class="fas fa-save"></i>  Simpan</strong>
                            </div>
                            <div wire:loading="" wire:target="resetStatusBarang">
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
                $('#closeModalAddPesananTambahan').click(); 
                $('#closeModalresetStatus').click(); 
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
