<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Print</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body>
    <section class="content  pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="invoice p-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    TOKO SAYUR <b>KASMI</b>
                                    <small class="float-right">{{  \Carbon\Carbon::parse($pemesanan->Invoice->tgl_terbit)->translatedFormat('l, d F Y')  }}</small>
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 50px">No</th>
                                            <th>Nama Barang</th>
                                            <th>Qty</th>
                                            <th>Harga Satuan</th>
                                            <th>Total Harga</th>
                                            <th>Cek </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($pemesanan->PemesananDetail->where('status_tersedia',1) as $item)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->Barang->nama_barang }}</td>
                                                <td>{{ $item->qty }} {{ $item->Satuan->satuan }}</td>
                                                <td></td>
                                                <td></td>
                                                <td><i class="far fa-square fa-2x"></i></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </section>
    <script>
        window.addEventListener("load", window.print());

    </script>
</body>

</html>
