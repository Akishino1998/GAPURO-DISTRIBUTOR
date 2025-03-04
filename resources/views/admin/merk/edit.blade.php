@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><a href="{{ route('admin.master.merk.index') }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a> <strong>Ubah Baru</strong></h3>
            </div>
            {!! Form::model($merk, ['route' => ['admin.master.merk.update', $merk->id], 'method' => 'patch']) !!}
            <div class="card-body">
                <div class="row">
                    @include('admin.merk.fields')
                </div>
            </div>
            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.master.merk.index') }}" class="btn btn-default">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
