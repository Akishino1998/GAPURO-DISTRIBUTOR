<div>
    <div class="form-group">
        <div class="input-group input-group">
            <input type="search" class="form-control form-control" placeholder="Cari Nama Toko" wire:model="search">
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
                <button class="btn btn-info btn-sm"style="width: 100%"><b><i class="fas fa-users"></i> Total Toko : {{ $countToko }}</b> </button>
            </div>
        </div>
        <table class="table" id="tokoPelanggans-table">
            <thead>
                <tr class="text-center">
                    <th style="width: 50px">No</th>
                    <th>Nama Toko</th>
                    <th>Nama Pemilik</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <script>
            </script>
                @foreach($toko as $item)
                    <tr class="text-center">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_toko }}</td>
                        <td>{{ $item->PemilikToko->name }}</td>
                        <td class="text-center">{{ $item->PemilikToko->email }}</td>
                        <td width="120">
                            <div class='btn-group'>
                                <a href="{{ route('toko.show', [$item->id]) }}" class='btn btn-info btn-sm'>
                                    <i class="far fa-eye"></i> Lihat
                                </a>
                                <a href="{{ route('toko.show', [$item->id]) }}" class='btn btn-info btn-sm'>
                                    <i class="far fa-eye"></i> Lihat
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (COUNT($toko)>0)
            @if (COUNT($toko )>=$limitPerPage)
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
