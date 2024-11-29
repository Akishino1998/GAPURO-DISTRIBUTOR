<div>
    <div class="table-responsive">
        <table class="table" id="tokoPelanggans-table">
            <thead>
                <tr class="text-center">
                    <th style="width: 50px">No</th>
                    <th>Nama</th>
                    <th>Tgl. Pemesanan</th>
                    <th>Tgl. Tiba</th>
                    <th>Status</th>
                    <th style="width: 120px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemesanan as $item)
                    <tr class="text-center">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $item->User->name }}</td>
                        <td class="text-center">{{ date("d F Y", strtotime($item->tgl_pemesanan)) }}</td>
                        <td class="text-center">{{ ($item->tgl_selesai!=null)?date("d F Y", strtotime($item->tgl_selesai)):"-" }}</td>
                        <td class="text-center">{!! $item->status($item->status) !!}</td>
                        <td class="bg-info">
                            <div class="btn-group"  wire:ignore.self>
                                <button  type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    Aksi<span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu"  wire:ignore.self>
                                    <a href="{{ route('admin.pemesanan.show',$item->id) }}" class="dropdown-item text-primary"><i class="fas fa-eye"></i> Lihat</a>
                                    {{-- <div class="dropdown-divider"></div> --}}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (COUNT($pemesanan)>0)
            @if (COUNT($pemesanan )>=$limitPerPage)
                <div>
                    <div class="d-flex justify-content-center mb-3">
                        <button class="btn btn-primary btn-sm" wire:loading.flex wire:target="loadMore"><span><b><i class="fas fa-circle-notch fa-spin "></i> Loading</b></span></button>
                        <button class="btn btn-primary btn-sm" wire:click="loadMore()"  wire:loading.remove wire:target="loadMore"><b>Lihat lainnya</b></button>
                    </div>
                </div>
            @endif
        @else
            <div wire:loading.remove>
                <div class="alert alert-danger" role="alert">
                    <p>Tidak Ada Datanya! </p>
                </div>
            </div>
        @endif
    </div>
    
</div>
