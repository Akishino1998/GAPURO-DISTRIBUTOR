@extends('layouts.app')

@section('content')
<section class="content pt-2 ">
    <div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-info card-outline">
					<div class="card-body">
						<h4><strong>Halo, <u>{{ auth()->user()->name }}</u> {{  \Carbon\Carbon::parse(NOW())->translatedFormat('F Y')  }}</strong></h>
					</div>
				</div>
			</div>
		</div>
        <div class="row">
			<div class="col-12">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="card">
							<div class="card-header border-0">
								<strong>Status Servis</strong>
							</div>
							<div class="card-body row">
								<div class="col-md-6 col-sm-6 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-info"><i class="fas fa-folder-open"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><strong>Total Pemesanan</strong></span>
											<span class="info-box-number">{{ COUNT($pemesanan) }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-warning"><i class="fas fa-tasks"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><strong>Belum Diproses</strong></span>
											<span class="info-box-number">{{ COUNT($pemesanan->whereIn('status',[1])) }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-success"><i class="fas fa-truck-loading"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><strong>Dalam Proses</strong></span>
											<span class="info-box-number">{{ COUNT($pemesanan->whereIn('status',[2,3,4,5,6])) }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-info"><i class="fas fa-user-check"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><strong>Selesai</strong></span>
											<span class="info-box-number">{{ COUNT($pemesanan->whereIn('status',[7,8])) }}</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">
						<div class="card-title">
							<strong><i class="fas fa-boxes"></i> Permintaan Pemesanan </strong>
						</div>
					</div>
					<div class="card-body table-responsive">
						<table class="table table-sm table-striped table-hover " id="servisan-table" wire:ignore.self="">
							<thead wire:ignore="">
								<tr class="text-center">
									<th style="width: 50px">No</th>
									<th>Tgl. Permintaan</th>
									<th>Nama Pemesanan</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody class="text-center">
								@foreach ($pemesanan as $item)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td class="text-center">{{ $item->User->name }}</td>
										<td class="text-center">{{ date("d F Y", strtotime($item->tgl_pemesanan)) }}</td>
										<td class="text-center">{!! $item->status($item->status) !!}</td>
										<td class="text-center"><a class="btn btn-info btn-sm" target="_blank" href="{{ route('admin.pemesanan.show',$item->id) }}"> <i class="fas fa-eye    "></i></a></td>
									</tr>
								@endforeach
							</tbody>
						</table>
						@if (COUNT($pemesanan)==0)
							<div class="alert alert-success text-center" role="alert">
								<span class="text-bold text-lg">Tidak Pemesanan</span>
							</div>
						@endif
						
					</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
