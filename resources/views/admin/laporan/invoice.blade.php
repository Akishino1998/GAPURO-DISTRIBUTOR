@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="card-title">
                    <h5 style="margin-bottom: 0px"><strong>Invoice</strong></h5>
                </div>
            </div>
            <div class="card-body row">
                <div class="col-md-12 col-sm-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <strong>Laporan Keseluruhan Invoice</strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-sign-in-alt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><strong>Total Invoice</strong></span>
                                            <span class="info-box-number">{{ COUNT($invoice) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning"><i class="fas fa-tools"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><strong>Invoice Lunas</strong></span>
                                            <span class="info-box-number">{{ COUNT($invoice->where('status',3)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="fas fa-clipboard-check"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><strong>Belum Dibuat</strong></span>
                                            <span class="info-box-number">{{ COUNT($invoice->where('status',1)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="fas fa-hands"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><strong>Belum Jatuh Tempo</strong></span>
                                            <span class="info-box-number">{{ COUNT($invoice->where('status',2)->where('tgl_tempo',">",date("Y-m-d H:m:i", strtotime(NOW())))) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><strong>Sudah Jatuh Tempo</strong></span>
                                            <span class="info-box-number">{{ COUNT($invoice->where('status',2)->where('tgl_tempo',"<",date("Y-m-d H:m:i", strtotime(NOW())))) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <strong>Laporan Keuangan Keseluruhan Invoice</strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-sign-in-alt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><strong>Total Invoice</strong></span>
                                            <span class="info-box-number">{{ "Rp. " .  number_format($invoiceGet->totalInvoice(), 0, ",", ".") }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-hands"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><strong>Total Invoice Lunas</strong></span>
                                            <span class="info-box-number">{{ "Rp. " .  number_format($invoiceGet->totalInvoiceLunas(), 0, ",", ".") }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning"><i class="fas fa-tools"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><strong>Invoice Belum Jatuh Tempo</strong></span>
                                            <span class="info-box-number">{{ "Rp. " .  number_format($invoiceGet->totalInvoiceBelumJatuhTempo(), 0, ",", ".") }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="fas fa-clipboard-check"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text"><strong>Invoice Jatuh Tempo</strong></span>
                                            <span class="info-box-number">{{ "Rp. " .  number_format($invoiceGet->totalInvoiceJatuhTempo(), 0, ",", ".") }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12  col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline card-success">
                                <div class="card-header">
                                    <div class="card-title">
                                        <strong>Daftar Invoice</strong>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-sm table-striped table-hover " id="servisan-table" wire:ignore.self="">
                                        <thead wire:ignore="">
                                            <tr>
                                                <th>No</th>
                                                <th style="width: 150px">No. Invoice</th>
                                                <th>Penerima</th>
                                                <th>Tgl. Jatuh Tempo</th>
                                                <th>Nominal</th>
                                                <th>Status</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoice->whereIn('status',[2,3]) as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->no_invoice }}</td>
                                                    <td>{{ $item->penerima }}</td>
                                                    <td>{{ date("d F Y", strtotime($item->tgl_tempo)) }}</td>
                                                    <td>{{ "Rp. " .  number_format($item->totalPerInvoice($item->id), 0, ",", ".") }}</td>
                                                    <td> 
                                                        @if ($item->status == 1)
                                                            <span class="badge bg-secondary"><i class="fas fa-spinner fa-spin"></i> Belum Diproses</span>
                                                        @elseif ($item->status == 2)
                                                            <span class="badge bg-primary"><i class="fas fa-file-invoice"></i> Terbit</span>
                                                        @elseif ($item->status == 3)
                                                            <span class="badge bg-success">Lunas</span>
                                                        @endif
                                                    </td>
                                                    <td><a class="btn btn-primary btn-sm" href="{{ route('admin.pemesanan.invoice',$item->id_pemesanan) }}"> <i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

