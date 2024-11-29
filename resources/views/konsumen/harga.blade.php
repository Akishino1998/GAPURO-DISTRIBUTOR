@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="card-title">
                    <h5 style="margin-bottom: 0px"><strong>Daftar Harga Konsumen {{ $konsumen->name }}</strong></h5>
                </div>
                <div class="card-option">
                    <a class="btn btn-primary btn-sm float-right" href="{{ route('konsumen.setHarga',$konsumen->id) }}"><i class="fas fa-user-plus    "></i> Tambah Data Harga Barang </a>
                </div>
            </div>
            <div class="card-body">
                <livewire:konsumen.harga :konsumen=$konsumen >
            </div>
        </div>
    </div>
@endsection

