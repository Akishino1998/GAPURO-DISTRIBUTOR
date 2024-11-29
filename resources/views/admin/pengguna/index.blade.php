@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <strong>Pengguna Aplikasi</strong>
                </div>
                <div class="card-options">
                    <a class="btn btn-primary float-right btn-sm" href="{{ route('admin.master.user.create') }}" style="float: right">
                        <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('admin.pengguna.table')
            </div>
        </div>
    </div>
@endsection

