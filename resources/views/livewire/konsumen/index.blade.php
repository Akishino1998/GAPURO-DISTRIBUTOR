<div>
    <div class="form-group">
        <div class="input-group input-group">
            <input type="search" class="form-control form-control" placeholder="Cari Nama Konsumen" wire:model="search">
            <div class="input-group-append">
                <button type="submit" class="btn btn btn-default">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <div class="row">
            <div class="col-12 mb-2">
                <button class="btn btn-info btn-sm"style="width: 100%"><b><i class="fas fa-users"></i> Total Konsumen : {{ $countUser }}</b> </button>
            </div>
        </div>
        <table class="table" id="tokoPelanggans-table">
            <thead>
                <tr class="text-center">
                    <th style="width: 50px">No</th>
                    <th>Nama Konsumen</th>
                    <th>Email</th>
                    <th style="width: 120px">Action</th>
                </tr>
            </thead>
            <tbody>
            <script>
            </script>
                @foreach($user as $item)
                    <tr class="text-center">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ $item->email }}</td>
               
                        <td class="bg-info">
                            <div class="btn-group"  wire:ignore.self>
                                <button  type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    Aksi<span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu"  wire:ignore.self>
                                    <a href="{{ route('konsumen.harga',$item->id) }}" class="dropdown-item text-primary"><i class="fas fa-eye"></i> Lihat Daftar Harga</a>
                                    {{-- <div class="dropdown-divider"></div> --}}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (COUNT($user)>0)
            @if (COUNT($user )>=$limitPerPage)
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
