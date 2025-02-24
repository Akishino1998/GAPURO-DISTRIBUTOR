@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
<div>
    <div class="table-responsive  p-2">
        <div class="row">
            <input type="hidden" name="time_start" id="time_start" wire:model="time_start">
            <input type="hidden" name="time_end" id="time_end" wire:model="time_end">
            <div class="col-12">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    Laba rugi diambil dari invoice yang telah dibayar dan dihitung mmenurut tanggal pembayaran!
                </div>
            </div>
            <div class="col-sm-12">
                <label for="dates" class="form-label">Tgl Transaksi</label>
                <input id="date_range" class="datepicker-here form-control digits" autocomplete="off" readonly required>
            </div>
            <div class="col-12 mt-5" wire:loading.remove="">
                @php
                    $totalInvoice = 0;
                    $totalPembelian = 0;
                foreach ($invoice as $item){
                    $totalInvoice += $item->totalPerInvoice($item->id);
                    foreach ($item->Pemesanan->PemesananDetail->where('status_barang_user',1)->where('tgl_harga_acc',"!=",null) as $itemsDetailPemesanan) {
                        foreach ($itemsDetailPemesanan->Penyiapan as $itemDibeli) {
                            $totalPembelian += $itemDibeli->total_modal;
                        }
                    }
                }
                @endphp
                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <th colspan="3" style="background: #e0e0e0;">Pendapatan Usaha</th>
                        </tr>
                        <tr>
                            <td>Pendapatan </td>
                            <td></td>
                            <th style="vertical-align: middle;text-align:right;">{{ "Rp. " .  number_format( $totalInvoice, 0, ",", ".") }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="background: #e0e0e0;">Pembelian</th>
                        </tr>
                        <tr>
                            <td>Pembelian</td>
                            <td style="vertical-align: middle;text-align:right;">{{ "Rp. " .  number_format($totalPembelian, 0, ",", ".") }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Total Pembelian</th>
                            <td style="border-top:2px solid black;"></td>
                            <th style="vertical-align: middle;text-align:right;">({{ "Rp. " .  number_format($totalPembelian, 0, ",", ".") }})</th>
                        </tr>
                        
                        <tr>
                            <th>Laba Bersih</th>
                            <td></td>
                            @php
                                $labaBersih = $totalInvoice-$totalPembelian;
                            @endphp
                            <th style="vertical-align: middle;text-align:right;border-top:2px solid black;">{{ ($labaBersih>0)?"Rp. " .  number_format($labaBersih, 0, ",", "."):"(Rp. " .  number_format($labaBersih, 0, ",", ".").")" }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    const now = new Date();
    var today = new Date(now.getFullYear(), now.getMonth(), 1);
    var endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
    $('#date_range').daterangepicker({
        startDate: today,
        endDate: endDate,
        locale: {
            format: 'DD MMMM YYYY'
        }
    }, function (start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format(
            'YYYY-MM-DD'));
        $("#time_start").val(start.format('YYYY-MM-DD'));
        $("#time_end").val(end.format('YYYY-MM-DD'));
        @this.call('set_date', start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))
    });

</script>
@endsection
