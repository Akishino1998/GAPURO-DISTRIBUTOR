<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Pemesanan extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'pemesanan';
    protected $dates = ['deleted_at'];
    function status($status){
        if($status == 0){
            return '<strong><span class="badge bg-danger"><i class="fas fa-times"></i> Dibatalkan</span></strong>';
        }else if ($status == 1) {
            return '<span class="badge bg-secondary"><i class="fas fa-spinner fa-spin"></i> Belum Diproses</span>';
        }else if ($status == 2) {
            return '<span class="badge bg-info"><i class="fas fa-file-signature"></i> Permintaan Harga</span>';
        }else if ($status == 3) {
            return '<span class="badge bg-info"><i class="fas fa-file-signature"></i> Penawaran Harga</span>';
        }else if ($status == 4) {
            return '<span class="badge bg-success"><i class="fas fa-truck-loading"></i> Pesanan Sedang Disiapkan</span>';
        }else if ($status == 6) {
            return '<span class="badge bg-primary"><i class="fas fa-truck"></i> Dalam Pengiriman</span>';
        }else if ($status == 5) {
            return '<span class="badge bg-success"><i class="fas fa-truck"></i> Barang Sudah Sampai</span>';
        }else if ($status == 7) {
            return '<span class="badge bg-success"><i class="fas fa-user-check"></i> Telah diserahkan ke konsumen</span>';
        }else if ($status == 8) {
            return '<span class="badge bg-success"><i class="fas fa-user-check"></i> Sudah diterima, menunggu pembayaran</span>';
        }else if ($status == 9) {
            return '<span class="badge bg-success"><i class="fas fa-user-check"></i> Sudah diterima</span>';
        }
    }
    function colorStatus($status){
        if($status == 0){
            return 'danger';
        }else if ($status == 1) {
            return 'secondary';
        }else if ($status == 2) {
            return 'info';
        }else if ($status == 3) {
            return 'info';
        }else if ($status == 4) {
            return 'success';
        }else if ($status == 6) {
            return 'primary';
        }else if ($status == 5) {
            return 'success';
        }else if ($status == 7) {
            return 'success';
        }else if ($status == 8) {
            return 'success';
        }else if ($status == 9) {
            return 'success';
        }
    }
    function imgStatus($status){
        if($status == 0){
            return asset('img/status/stat0.png');
        }else if ($status == 1) {
            return asset('img/status/stat01.png');
        }else if ($status == 2) {
            return asset('img/status/stat02.png');
        }else if ($status == 3) {
            return asset('img/status/stat03.png');
        }else if ($status == 4) {
            return asset('img/status/stat04.png');
        }else if ($status == 6) {
            return asset('img/status/stat05.png');
        }else if ($status == 5) {
            return asset('img/status/stat08.png'); 
        }else if ($status == 7) {
            return asset('img/status/stat06.png');
        }else if ($status == 8) {
            return asset('img/status/stat10.png');
        }else if ($status == 9) {
            return asset('img/status/stat09.png');
        }
    }
    function setTimelinePemesanan($id){
        $pemesanan = Pemesanan::find($id);
        $timeline = new PemesananTimeLine;
        $timeline->id_pemesanan = $pemesanan->id;
        $timeline->title = $pemesanan->status;
        $timeline->icon = $pemesanan->status;
        $timeline->color = $pemesanan->status;
        if($pemesanan->status == 0){
            $timeline->keterangan = "Pemesanan dibatalkan!";
            $timeline->save();
        }else if ($pemesanan->status == 1) {
            $timeline->keterangan = "Pemesanan dibuat, akan dicek oleh admin!";
            $timeline->save();
        }else if ($pemesanan->status == 2) {
            $timeline->keterangan = "Permintaan harga diajukan, mohon tunggu!";
            $timeline->save();
        }else if ($pemesanan->status == 3) {
            $timeline->keterangan = "Penawaran harga dibuat, menunggu persetujuan!";
            $timeline->save();
        }else if ($pemesanan->status == 4) {
            $timeline->keterangan = "Pesananmu sedang disiapkan!";
            $timeline->save();
        }else if ($pemesanan->status == 5) {
            $timeline->keterangan = "Pesananmu telah sampai!";
            $timeline->save();
        }else if ($pemesanan->status == 6) {
            $timeline->keterangan = "Dalam Pengiriman!";
            $timeline->save();
        }else if ($pemesanan->status == 7) {
            $timeline->keterangan = "Sudah sampai, konsumen menerima!";
            $timeline->save();
        }else if ($pemesanan->status == 8) {
            $timeline->keterangan = "Diterima, menunggu pembayaran!";
            $timeline->save();
        }else if ($pemesanan->status == 9) {
            $timeline->keterangan = "Pemesanan selesai!";
            $timeline->save();
        }
    }
    function totalPemesanan($id){
        $pemesanan = Pemesanan::find($id);
        $total = 0;
        $pajak = 0;
        foreach ($pemesanan->PemesananDetail->where('status_tersedia',1) as $item) {
            $pajak += (($item->harga_per_satuan*$item->qty)*0.015);
            $total+=($item->harga_per_satuan*$item->qty)+(($item->harga_per_satuan*$item->qty)*0.015);
        }
        return $total;
    }
    function cekStatusHarga($id){
        $pemesanan = Pemesanan::find($id);
        $cekHarga = 0;
        foreach ($pemesanan->PemesananDetail as $item) {
            if ($item->status_barang == 1) {
                $cekHarga++;
            }
        }
        foreach ($pemesanan->PemesananRequest as $item) {
            if ($item->status_request == 1) {
                $cekHarga++;
            }
        }
        return $cekHarga;
    }
    function cekStatusHargaTambahan($id){
        $pemesanan = Pemesanan::find($id);
        $cekHarga = 0;
        foreach ($pemesanan->PemesananTambahan as $item) {
            if ($item->harga_jual == null or $item->harga_jual == 0) {
                $cekHarga++;
            }
        }
        return $cekHarga;
    }
    function cekStatusTambahan($id){
        $pemesanan = Pemesanan::find($id);
        $cekRequest = 0;
        foreach ($pemesanan->PemesananTambahan as $item) {
            if ($item->status_pemesanan == 1 ) {
                $cekRequest++;
            }
        }
        return $cekRequest;
    }
    function cekStatusRequest($id){
        $pemesanan = Pemesanan::find($id);
        $cekRequest = 0;
        foreach ($pemesanan->PemesananRequest as $item) {
            if ($item->status_request == 1) {
                $cekRequest++;
            }
        }
        return $cekRequest;
    }
    function cekStatusHargaUser($id){
        $pemesanan = Pemesanan::find($id);
        $cekHarga = 0;
        foreach ($pemesanan->PemesananDetail as $item) {
            if ($item->status_barang_user == 2) {
                $cekHarga++;
            }
        }
        return $cekHarga;
    }
    function cekStatusPembelian($id){
        $pemesanan = Pemesanan::find($id);
        $cekPembelian = 0;
        foreach ($pemesanan->PemesananDetail as $item) {
            if ($item->status_tersedia == 2 and $item->status_barang_user == 1) {
                $cekPembelian++;
            }
        }
        return $cekPembelian;
    }
    function cekStatusPenerimaan($id){
        $pemesanan = Pemesanan::find($id);
        $cekPembelian = 0;
        foreach ($pemesanan->PemesananDetail as $item) {
            if ($item->status_diterima == 2 & $item->status_tersedia == 2) {
                $cekPembelian++;
            }
        }
        return ($cekPembelian>=COUNT($pemesanan->PemesananDetail->where('status_tersedia',2)))?true:false;
    }
    function cekStatusPenerimaanKonsumen($id){
        $pemesanan = Pemesanan::find($id);
        $cekPembelian = 0;
        foreach ($pemesanan->PemesananDetail->where('status_tersedia',2) as $item) {
            if ($item->tgl_diterima_user == null || $item->tgl_diterima == null ) {
                $cekPembelian++;
            }
        }
        return ($cekPembelian==0)?true:false;
    }
    public function UNIQUE_KODE(){
        $ts = strtotime(NOW());
        $first_day_this_month = date('Y-m-01 00:00:00',$ts);
        $last_day_this_month  = date('Y-m-t 23:59:59',$ts);
        $servisan = Pemesanan::where('id_user',auth()->user()->id)->whereBetween('created_at', array($first_day_this_month, $last_day_this_month))->get();
        $totalUser = str_pad(COUNT($servisan)+1, 3, '0', STR_PAD_LEFT);
        $today = date("dmy");
        return "PO/0".auth()->user()->id."/".$totalUser."/".$today;
    } 
    public function PemesananTimeLine()
    {
        return $this->hasMany(PemesananTimeLine::class, 'id_pemesanan', 'id')->latest();
    }
    public function PemesananDetail()
    {
        return $this->hasMany(PemesananDetail::class, 'id_pemesanan', 'id');
    }
    public function PemesananRequest()
    {
        return $this->hasMany(PemesananRequest::class, 'id_pemesanan', 'id');
    }
    public function PemesananTambahan()
    {
        return $this->hasMany(PemesananTambahan::class, 'id_pemesanan', 'id');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function Invoice()
    {
        return $this->hasOne(Invoice::class, 'id_pemesanan', 'id');
    }

}
