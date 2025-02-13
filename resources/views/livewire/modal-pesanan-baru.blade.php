<div wire:poll.5000ms>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="modal fade" id="modalPemesananTerbaru" wire:ignore.self >
        <div class="modal-dialog modal-lg"  wire:ignore.self>
            <div class="modal-content"  wire:ignore.self>
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Pemesanan Terbaru</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <input type="hidden" wire:model="countPemesanan" id="countPemesanan">
                    <div class="col-xl-3 col-md-12">
                        <img src="{{ asset('img/status/stat11.png') }}" alt="" style="display: block; width: 100%;">
                    </div>
                    <div class="offset-xl-1 col-xl-8 col-md-12">
                        <div class="table-responsive">
                            <table class="table" id="tokoPelanggans-table">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 50px">No</th>
                                        <th>Nama</th>
                                        <th>Tgl. Pemesanan</th>
                                        <th style="width: 120px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pemesanan as $item)
                                        <tr class="text-center">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->User->name }}</td>
                                            <td class="text-center">{{ date("d F Y", strtotime($item->tgl_pemesanan)) }}</td>
                                            <td>
                                                <a href="{{ route('admin.pemesanan.show',$item->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Lihat</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if (COUNT($pemesanan)==0)
                                <div class="alert alert-info" role="alert">
                                    <p>Semua pesanan baru sudah diproses </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <script>
            setInterval(function () {
                let data = $("#countPemesanan").val();
                if (data>0) {
                    $('#modalPemesananTerbaru').modal('show');
                }
            }, 5000);
        </script>        
    </div>
</div>