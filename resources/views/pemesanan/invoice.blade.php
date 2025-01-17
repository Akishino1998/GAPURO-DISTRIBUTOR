@extends('layouts.app')
@section('content')
<section class="content  pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{ route('pemesanan.show',$pemesanan->id) }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a>  <strong>Invoice</strong>
                        </h3>
                        <div class="card-options float-right">
                            @if ($pemesanan->Invoice->status == 2)
                            @else
                            <button class="btn btn-success btn-sm"><i class="fas fa-file-invoice"></i> Lunas </button>
                            @endif
                        </div>    
                    </div>
                    <div class="card-body">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            Invoice masih bisa diubah sampai konsumen membayar tagihan.
                        </div>
                    </div>
                </div>
                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                TOKO SAYUR <b>KASMI</b>  
                            @if ($pemesanan->Invoice->status == 1)
                                <span class="badge bg-secondary"><i class="fas fa-spinner fa-spin"></i> Belum Diproses</span>
                            @elseif ($pemesanan->Invoice->status == 2)
                                <span class="badge bg-primary"><i class="fas fa-file-invoice"></i> Terbit</span>
                            @elseif ($pemesanan->Invoice->status == 3)
                                <span class="badge bg-success"><i class="fas fa-file-invoice"></i> Lunas</span>
                            @endif
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
                            <b>Tgl. Jatuh Tempo:</b> {{  ($pemesanan->Invoice->tgl_tempo==null)?"-":\Carbon\Carbon::parse($pemesanan->Invoice->tgl_tempo)->translatedFormat('l, d F Y')  }}<br>
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
									@foreach ($pemesanan->PemesananDetail->where('status_tersedia',1) as $item)
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
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</section>
<div class="modal fade" id="modalProsesPemesanan">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.pemesanan.invoiceBayar',$pemesanan->id) }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="callout callout-warning">
                        <h5><i class="fas fa-success"></i> Note:</h5>
                        Pembayaran Invoice telah diterima?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalProsesPembelian" data-dismiss="modal" >Batal</button>
                    <button class="btn btn-primary" type="submit" ><strong style="color: white"><i class="fas fa-check-double"></i> Diterima Dan Lunas</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalBarangSiap">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.pemesanan.invoiceSimpan',$pemesanan->id) }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Informasi Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-warning card-outline">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Penerima</label>
                                        <input type="text" class="form-control" name="penerima" placeholder="Penerima">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Jatuh Tempo</label>
                                        <input type="date" class="form-control" name="tgl_tempo" placeholder="Tgl. Jatuh Tempo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalProsesPembelian" data-dismiss="modal" >Batal</button>
                    <button class="btn btn-primary" type="submit" ><strong style="color: white"><i class="fas fa-save"></i>  Simpan</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
