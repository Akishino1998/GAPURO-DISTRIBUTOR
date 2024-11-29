@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><a href="{{ route('toko.index') }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a> <strong>Tambah Baru</strong></h3>
            </div>
            {!! Form::open(['route' => 'toko.store']) !!}
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        {!! Form::label('nama_toko', 'Nama Toko') !!}
                        {!! Form::text('nama_toko', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100]) !!}
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-warning" role="alert">
                                            Membuat data toko harus membuat akun untuk akses toko tersebut!
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="name">Nama</label> <span class="badge bg-primary">Wajib</span>
                                        <input class="form-control" maxlength="255" name="name" type="text" id="name">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="email">Email</label> <span class="badge bg-primary">Wajib</span>
                                        <input class="form-control" maxlength="255" name="email" type="email" id="email">
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-info" role="alert">
                                            Password default toko " <b>12345678</b> " dan toko dapat mengganti password tersebut!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary text-white" type="submit" style="width: 100%"> <i class="fas fa-save    "></i> Simpan</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
