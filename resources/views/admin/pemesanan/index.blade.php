@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="card-title">
                    <h5 style="margin-bottom: 0px"><strong>Data Pemesanan</strong></h5>
                </div>
            </div>
            <div class="card-body">
                <livewire:admin.pemesanan.index >
            </div>
        </div>
    </div>
@endsection

