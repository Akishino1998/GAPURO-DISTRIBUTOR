@extends('layouts.app')

@section('content')
   
    <div class="content px-3 pt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <div class="card-title">
                            <strong><a class="btn btn-primary text-white btn-sm " href="{{ route('toko.index') }}"><i class="fas fa-backward"></i>   Kembali </a> Informasi Toko</strong>
                        </div>
                        <div class="card-option float-right">
                            {!! Form::open(['route' => ['toko.destroy', $toko->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{{ route('toko.edit', [$toko->id]) }}" class='btn btn-primary btn-sm'>
                                    <i class="far fa-edit"></i> Edit
                                </a>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="far fa-trash-alt"></i> Hapus</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="card-body">
                        <table>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><strong>{{ $toko->PemilikToko->nama }}</strong></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><strong>{{ $toko->PemilikToko->email }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <strong><i class="fas fa-wrench"></i> Riwayat Servis</strong>
                    </div>
                    <div class="card-body" id="accordion">
                        <div class="card-body">
                            <div class="timeline" style="">
                                @foreach ($servisan as $items)
                                    <div class="time-label">
                                        <span class="bg-{{ $items->colorStatus($items->status) }}">{{ date("d M Y", strtotime($items->created_at)) }}</span>
                                    </div>
                                    <div>
                                        <div class="timeline-item">
                                            <h3 class="timeline-header"><span class="badge rounded-pill bg-{{ $items->colorStatus($items->status) }}">{!! $items->statusIcon($items->status) !!} {{ $items->status($items->status) }}</span>  <a href="{{ route('servisan.info') }}?servisan={{ $items->kode_servisan }}" style="color: black"><strong>{{ $items->kode_servisan }} <i class="fas fa-external-link    "></i><i class="fas fa-external-link-alt"></i> </strong></a>  </h3>
                                            <div class="timeline-body">
                                                <h6><strong>Informasi Servisan</strong></h6>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>Elektronik</td>
                                                            <td>:</td>
                                                            <td><strong>{{ $items->PelangganElektronik->JenisElektronik->nama_elektronik }} {{ $items->PelangganElektronik->Merk->merk }} {{ $items->PelangganElektronik->type }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Warna</td>
                                                            <td>:</td>
                                                            <td><strong>{{ ($items->PelangganElektronik->warna == null)?"-":$items->PelangganElektronik->warna }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kerusakan</td>
                                                            <td>:</td>
                                                            <td><strong>{{ $items->kerusakan }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Biaya</td>
                                                            <td>:</td>
                                                            <td>
                                                                <strong>
                                                                    @if ($items->status == 5)
                                                                        <span class="badge bg-primary">Konfirmasi</span> {{ "Rp. " .  number_format($items->biaya_konfirmasi, 0, ",", ".") }}
                                                                    @else
                                                                    {{ "Rp. " .  number_format($items->total_biaya, 0, ",", ".") }}
                                                                    @endif
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tgl. Servis</td>
                                                            <td>:</td>
                                                            <td><strong>{{  \Carbon\Carbon::parse($items->tgl_masuk)->translatedFormat('H:i - l, d F Y')  }}</strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if ($items->can_remove == "Y" )
                                                <div class="timeline-footer">
                                                    <a class="btn btn-danger btn-sm"  wire:click="setHapusTrackServis({{ $items->id }})"><i  wire:loading wire:target="setHapusTrackServis" class="fas fa-circle-notch fa-spin"></i><i wire:loading.remove wire:target="setHapusTrackServis" class="fas fa-trash    "></i> Hapus</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                <div>
                                    <i class="fas fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openWAChat(no_wa){
            let noWA = no_wa;
            let text = 'Halo kak...';
            var href = `https://wa.me/${noWA}?text=${text}`;
            window.open(
                href,
                "Chat Ke Pelanggan",
                "resizable,scrollbars,status"
            );
        }
    </script>
@endsection
