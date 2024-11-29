@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="card-title">
                    <h5 style="margin-bottom: 0px"><strong>Data Toko</strong></h5>
                </div>
                <div class="card-option">
                    <a class="btn btn-primary btn-sm float-right" href="{{ route('toko.create') }}"><i class="fas fa-user-plus    "></i> Tambah Data Toko </a>
                </div>
            </div>
            <div class="card-body">
                <livewire:toko.index>
            </div>
        </div>
    </div>
@endsection

