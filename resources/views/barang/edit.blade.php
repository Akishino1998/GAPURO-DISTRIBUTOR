@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        @include('adminlte-templates::common.errors')
        {!! Form::model($barang, ['route' => ['barang.update', $barang->id], 'method' => 'patch','enctype'=>'multipart/form-data']) !!}
                @include('barang.fieldEdit')
        {!! Form::close() !!}
    </div>
@endsection
