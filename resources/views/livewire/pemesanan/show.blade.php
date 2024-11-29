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
                    <a href="{{ route('toko.index') }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a> <strong>Pemesanan {!! $pemesanan->Status($pemesanan->status) !!}</strong>
                </h3>
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
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
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
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($pemesanan->PemesananDetail as $item)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->Barang->Kategori->kategori }}</td>
                                        <td>{{ $item->Barang->nama_barang }}</td>
                                        <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_jual, 0, ",", ".") }}
                                        </td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->Satuan->satuan }}</td>
                                        <td>{{ ($item->harga_jual==null)?"-":"Rp. " .  number_format($item->harga_jual*$item->qty, 0, ",", ".") }}
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
</div>
@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

@endsection
