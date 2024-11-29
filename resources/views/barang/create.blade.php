@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        @include('adminlte-templates::common.errors')
        {!! Form::open(['route' => 'barang.store','enctype'=>'multipart/form-data']) !!}
            @include('barang.fields')
        {!! Form::close() !!}
    </div>
@endsection
