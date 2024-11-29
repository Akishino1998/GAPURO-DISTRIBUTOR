<div class="table-responsive">
    <table class="table" id="penggunas-table">
        <thead>
        <tr>
            <th width="50">No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th style="width: 200px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($user as $pengguna)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pengguna->name }}</td>
                <td>{{ $pengguna->email }}</td>
                <td>{{ $pengguna->Role->role }}</td>
                @if ($pengguna->id != Auth::user()->id)
                    <td width="120">
                        {!! Form::open(['route' => ['admin.master.user.destroy', $pengguna->id], 'method' => 'delete']) !!}
                            @if ($pengguna->non_aktif != null)
                                {!! Form::button('<i class="fas fa-eye-slash"></i> Aktifkan', ['type' => 'submit', 'class' => 'btn btn-info btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            @else
                                {!! Form::button('<i class="fas fa-eye"></i> Non-Aktifkan', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            @endif
                        {!! Form::close() !!}
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

@endsection
