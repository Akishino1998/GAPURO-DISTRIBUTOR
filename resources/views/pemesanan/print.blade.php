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
    <div class="wrapper">
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
							<div class="row invoice-info">
								<div class="col-sm-4 invoice-col">
									TAGIHAN DARI,
									<address>
										<strong>TOKO SAYUR KASMI</strong><br>
									</address>
								</div>
								<div class="col-sm-4 invoice-col">
									DITUJUKAN KEPADA,
									<address>
										<strong>{{ $pemesanan->User->name }}</strong><br>
										{{ $pemesanan->keterangan_pemesanan }}<br>
									</address>
								</div>
								<div class="col-sm-4 invoice-col mb-2">
									<br>
									<b>No. Invoice:</b> {{ $pemesanan->Invoice->no_invoice }}<br>
									<b>Tgl. Pesan:</b> {{  \Carbon\Carbon::parse($pemesanan->tgl_pemesanan)->translatedFormat('l, d F Y')  }}<br>
									<b>Tgl. Jatuh Tempo:</b> {{  ($pemesanan->tgl_tempo==null)?"-":\Carbon\Carbon::parse()->translatedFormat('l, d F Y')  }}<br>
								</div>
							</div>
							<div class="row">
								<div class="col-12 table-responsive">
									<table class="table table-striped">
										<thead>
											<tr class="text-center">
												<th>No</th>
												<th>Jenis Barang</th>
												<th>Qty</th>
												<th>Harga Satuan</th>
												<th>PPh 1,5% </th>
												<th>Total </th>
											</tr>
										</thead>
										<tbody>
											@php
												$total = 0;
											@endphp
											@foreach ($pemesanan->PemesananDetail->where('status_barang_user',1) as $item)
												<tr class="text-center">
													<td>{{ $loop->iteration }}</td>
													<td>{{ $item->Barang->nama_barang }}</td>
													<td>{{ $item->qty }} {{ $item->Satuan->satuan }}</td>
													<td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format($item->harga_per_satuan, 0, ",", ".") }}</td>
													<td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format(($item->harga_per_satuan*$item->qty)*0.015, 0, ",", ".") }}</td>
													@php
														$total+=($item->harga_per_satuan*$item->qty)+($item->harga_per_satuan*$item->qty)*0.015;
													@endphp
													<td>{{ ($item->harga_per_satuan==null)?"-":"Rp. " .  number_format(($item->harga_per_satuan*$item->qty)+($item->harga_per_satuan*$item->qty)*0.015, 0, ",", ".") }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<p style="font-size:1rem">PEMBAYARAN DILAKUKAN MELALUI REKENING BANK BERIKUT INI:</p>
									<p class="text-black well well-sm shadow-none" style="margin-top: 10px;">
										{{ $pemesanan->Invoice->Bank->bank }} <br>
										{{ $pemesanan->Invoice->Bank->nama }} <br>
										{{ $pemesanan->Invoice->Bank->no_rek }}
									</p>
								</div>
								<div class="col-6">
									<div class="table-responsive">
										<table class="table">
											<tr>
												<th style="width:74%">Total:</th>
												<td>{{ "Rp. " .  number_format($total, 0, ",", ".") }}</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
    </div>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>
</html>
