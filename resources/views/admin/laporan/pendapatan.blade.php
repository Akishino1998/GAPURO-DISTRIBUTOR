@extends('layouts.app')
@section('content')
    <div class="content px-3 pt-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="card-title">
                    <h5 style="margin-bottom: 0px"><strong>Pendapatan</strong></h5>
                </div>
            </div>
            <div class="card-body">
                <livewire:laporan.pendapatan >
            </div>
        </div>
    </div>
@endsection

