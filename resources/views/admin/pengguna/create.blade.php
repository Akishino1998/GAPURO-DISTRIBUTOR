@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><a href="{{ route('admin.master.user.index') }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a> <strong>Tambah Baru Pengguna</strong></h3>
            </div>
            {!! Form::open(['route' => 'admin.master.user.store']) !!}
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            Sesuaikan role yang akan digunakan untuk pengguna!
                        </div>
                    </div>
                    @include('admin.pengguna.fields')
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary text-white" type="submit" style="width: 100%"> <i class="fas fa-save    "></i> Simpan</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
