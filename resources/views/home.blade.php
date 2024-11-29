@extends('layouts.app')

@section('content')
<section class="content pt-2 ">
    <div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-info card-outline">
					<div class="card-body">
						<h4><strong>Dashboard <u>Eko</u> {{  \Carbon\Carbon::parse(NOW())->translatedFormat('F Y')  }}</strong></h>
					</div>
				</div>
			</div>
		</div>
        <div class="row">
			<div class="col-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xl-4">
						<div class="card">
							<div class="card-header border-0">
								<strong>Omset</strong>
							</div>
							<div class="card-body row">
								<div class="col-md-12 col-sm-12 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-warning"><i class="fas fa-shopping-cart"></i></span>
										<div class="info-box-content"> 
											<span class="info-box-text"><strong>Omset Servisan</strong></span>
											<span class="info-box-number">{{ "Rp. " .  number_format(1000000, 0, ",", ".") }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-success"><i class="fas fa-thumbs-up"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><strong>Omset Sparepart</strong></span>
											<span class="info-box-number">{{ "Rp. " .  number_format(1000000, 0, ",", ".") }}</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 @if (auth()->user()->id_role == 2) col-xl-4 @else col-xl-6 @endif">
						<div class="card">
							<div class="card-header border-0">
								<strong>Status Servis</strong>
							</div>
							<div class="card-body row">
								<div class="col-md-6 col-sm-6 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-info"><i class="fas fa-sign-in-alt"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><strong>Total Servisan</strong></span>
											<span class="info-box-number">{{ 1 }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-warning"><i class="fas fa-tools"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><strong>Masuk & Diproses</strong></span>
											<span class="info-box-number">{{ 1 }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-success"><i class="fas fa-clipboard-check"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><strong>Selesai</strong></span>
											<span class="info-box-number">{{ 1 }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-info"><i class="fas fa-sign-out-alt"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><strong>Sudah Diambil</strong></span>
											<span class="info-box-number">{{ 1 }}</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 @if (auth()->user()->id_role == 2) col-xl-4 @else col-xl-6 @endif">
						<div class="card">
							<div class="card-header border-0">
								<strong>Status Penjualan Sparepart</strong>
							</div>
							<div class="card-body row">
								<div class="col-md-12 col-sm-12 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-info"><i class="fas fa-shopping-basket"></i></span>
										<div class="info-box-content">
											<span class="info-box-text"><strong>Total Penjualan</strong></span>
											<span class="info-box-number">{{ 1 }}</span>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-12">
									<div class="info-box">
										<span class="info-box-icon bg-warning"><i class="fas fa-shopping-cart"></i></span>
										<div class="info-box-content"> 
											<span class="info-box-text">Produk Terjual</span>
                     
											<span class="info-box-number">{{ 1 }}</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header">
						<div class="card-title">
							<strong><i class="fas fa-boxes    "></i> Permintaan Sparepart</strong>
						</div>
					</div>
					<div class="card-body table-responsive">
						<table class="table table-sm table-striped table-hover " id="servisan-table" wire:ignore.self="">
							<thead wire:ignore="">
								<tr class="text-center">
									<th>No</th>
									<th style="width: 100px">No. Servis</th>
									<th>Tgl. Permintaan</th>
									<th>Nama Sparepart</th>
									<th>Jumlah</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody class="text-center">
								
							</tbody>
						</table>
						<div class="alert alert-success text-center" role="alert">
							<span class="text-bold text-lg">Tidak Sparepart Yang Diminta</span>
						</div>
					</div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                          <p class="d-flex flex-column">
                            <span class="text-bold text-lg">Servisan Dalam 7 Hari Ini</span>
                          </p>
                        </div>
                        <div class="position-relative mb-4">
                          	<canvas id="visitors-chart" height="200"></canvas>
                        </div>
                        <div class="d-flex flex-row justify-content-end">
                          	<span class="mr-2">
                            	<i class="fas fa-square text-primary"></i> Servisan Masuk
                          	</span>
                          <span>
                            <i class="fas fa-square text-gray"></i> Servisan Sudah Diambil
                          </span>
                        </div>
                      </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
				<div class="card">
                    <div class="card-header">
                        <strong class="text-danger"><i class="fas fa-exclamation-triangle"></i> Servisan Urgent</strong>
                    </div>
                    <div class="card-body">
                        <livewire:dashboard.urgent>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <strong>Servisan Terlama Bulan Ini </strong>
                    </div>
                    <div class="card-body">
                        <livewire:dashboard.servisan>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
