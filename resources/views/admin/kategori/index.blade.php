@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>Kategori</strong>
                </h3>
                <div class="card-options float-right">
                    <a class="btn btn-primary btn-sm float-right" href="{{ route('admin.master.kategori.create') }}"> <i class="fas fa-plus    "></i> Tambah Kategori Baru </a>
                </div>
            </div>
            <div class="card-body p-0">
                @include('admin.kategori.table')
            </div>
        </div>
    </div>
@endsection

