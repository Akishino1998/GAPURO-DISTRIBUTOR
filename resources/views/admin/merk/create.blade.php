@extends('layouts.app')

@section('content')
    <div class="content px-3 pt-3">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><a href="{{ route('admin.master.merk.index') }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a> <strong>Tambah Baru</strong></h3>
            </div>
            {!! Form::open(['route' => 'admin.merk.store']) !!}
            <div class="card-body">
                <div class="row">
                    @include('admin.merk.fields')
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary text-white" type="submit" style="width: 100%"> <i class="fas fa-save    "></i> Simpan</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
