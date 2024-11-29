@section('css')
    <link href="{{ asset('assets/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection
@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript">
    function getNextData(){
        @this.call('loadMore')
    }
    function handle(e){
        if(e.keyCode === 13){
            e.preventDefault();
            $("#nama_part").blur();
        }
    }
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endsection
<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <strong>Data Sparepart</strong>
            </div>
            <div class="card-options">
                <div class="btn-group float-right">
                    <a class="btn btn-primary float-right btn-sm" href="{{ route('barang.create') }}" style="float: right">
                        <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-search    "></i>
                        </span>
                        <input type="search" class="form-control" autocomplete="off" placeholder="Nama Barang" wire:model="nama_barang" id="nama_barang"  onkeypress="handle(event)">
                    </div>
                </div>
                <table class="table table-hover"  wire:ignore.self>
                    <thead  wire:ignore>
                        <tr>
                            <th style="width: 50px">No</th>
                            <th style="width: 150px">Kategori</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th class="text-center" style="width: 150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                    @foreach($barang as $item)
                        <tr>
                            <td class="text-center">{{ $i++ }}</td>
                            <td><span class="badge bg-info">{{ $item->Kategori->kategori }}</span> <b></td>
                            <td><b>{{ $item->nama_barang }}</td>
                            <td><b>{{ ($item->id_satuan==null)?"-":$item->Satuan->satuan }}</td>
                            <td class="text-center">
                                {!! Form::open(['route' => ['barang.destroy', $item->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{{ route('barang.show', [$item->id]) }}" class='btn btn-info btn-sm'>
                                        <i class="far fa-eye"></i>
                                    </a> 
                                    <a href="{{ route('barang.edit', [$item->id]) }}" class='btn btn-primary btn-sm'>
                                        <i class="far fa-edit"></i>
                                    </a>
                                    {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if (COUNT($barang)>0)
                    @if (COUNT($barang)>=$limitPerPage)
                        <div>
                            <div class="d-flex justify-content-center mb-3">
                                <button class="btn btn-primary btn-sm" wire:loading.flex wire:target="loadMore"><span><b><i class="fas fa-circle-notch fa-spin "></i> Loading</b></span></button>
                                <button class="btn btn-primary btn-sm" onclick="getNextData()"  wire:loading.remove wire:target="loadMore"><b>Lihat lainnya</b></button>
                            </div>
                        </div>
                    @endif
                @else
                    <div wire:loading.remove wire:target="loadMore">
                        <div class="alert alert-danger" role="alert">
                            <p>Tidak Ada Datanya! </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if (session()->has('message'))
        <script>
            Toast.fire({
                icon: 'success',
                title: '{{ session("message") }}'
            });
            $('#closeBatasStok').click(); 
        </script>
    @endif
</div>
