@section('css')
    <link href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}"  rel="stylesheet">
    <link href="{{ asset('assets/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
@endsection
@section('js')
    <script src="{{ asset('assets/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/dataTables.responsive.min.js') }}"></script>
    <script>
    $('#merk-table').DataTable({
        paging: false,
        "order": [],
        bInfo: false
    });

    </script>
@endsection
<div class="table-responsive">
    <table class="table" id="merk-table">
        <thead>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($kategoris as $kategori)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kategori->kategori }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.master.kategori.destroy', $kategori->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.master.kategori.edit', [$kategori->id]) }}"
                           class='btn btn-primary btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
