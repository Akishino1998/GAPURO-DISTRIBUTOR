@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>Satuan</strong>
                </h3>
                <div class="card-options float-right">
                    <a class="btn btn-primary btn-sm float-right" href="{{ route('admin.master.satuan.create') }}"> <i class="fas fa-plus    "></i> Tambah Satuan Baru </a>
                </div>
            </div>
            <div class="card-body p-0">
                @include('admin.satuan.table')
            </div>
        </div>
    </div>
@endsection

