<div class="ibox card">
    <div class="card-header">
        <h3 class="card-title"><a href="{{ route('barang.index') }}" class="btn btn-primary btn-sm"><strong><i class="fas fa-backward    "></i> Kembali</strong></a> <strong>Informasi Barang</strong></h3>
        <div class="card-options float-right">
            <a href="{{ route('barang.edit', [$barang->id]) }}" class="btn btn-info btn-sm"><strong><i class="fas fa-edit    "></i> Edit</strong></a> 
        </div>
    </div>
    <div class="card-body">
        <div class="ibox-content">
            <div class="row mb-3">
                <div class="col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="bg-light text-center br-4">
                                <div class="p-2">
                                    <img src="{{ ($barang->foto==null)? asset('no-foto.png'):asset('storage/')."/".$barang->foto }}" alt="img" class="img-fluid w-50">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-1">
                                <span href="#" class="text-navy">{{ $barang->nama_barang }} </span>
                            </h3>
                            <hr style="margin:10px 0px;">
                            <div>
                                <table>
                                    <tr>
                                        <th style="width: 150px">Kategori</th>
                                        <td>{{ $barang->Kategori->kategori }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 150px">Merk</th>
                                        <td>{{ ($barang->id_merk==null)?"-":$barang->Merk->merk }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 150px">Satuan</th>
                                        <td>{{ ($barang->id_satuan==null)?"-":$barang->Satuan->satuan }}</td>
                                    </tr>
                                </table>
                            </div>
                            <hr style="margin:10px 0px;">
                            <div>
                                <h5 class="mt-3">Deskripi</h5>
                                <p>
                                    {!! ($barang->deskripsi==null)?"-":$barang->deskripsi  !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>