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
    // 0 batal
    // 1 belum diproses
    // 2 penentuan harga
    // 3 penawaran harga
    // 4 barang disiapkan

    // 5 barang sudah siap, menunggu pengiriman

    // 6 barang dalam perjalanan
    // 7 barang sudah tiba, proses cek kurir dan konsumen

    // 8 barang sesuai dan selesai belum dibayar
    // 9 barang kurang
    // 10 selesai, belum dibayar
    // 11 lunas
    function status($status){
        if($status == 0){
            return '<strong><span class="badge bg-danger"><i class="fas fa-times"></i> Dibatalkan</span></strong>';
        }else if ($status == 1) {
            return '<span class="badge bg-warning"><i class="fas fa-spinner fa-spin"></i> Proses</span>';
        }else if ($status == 2) {
            return '<span class="badge bg-info"><i class="fas fa-file-signature"></i> Pengajuan Harga</span>';
        }else if ($status == 3) {
            return '<span class="badge bg-info"><i class="fas fa-file-signature"></i> Penawaran Harga</span>';
        }else if ($status == 4) {
            return '<span class="badge bg-success"><i class="fas fa-truck-loading"></i> Pesanan Sedang Disiapkan</span>';
        }else if ($status == 6) {
            return '<span class="badge bg-success"><i class="fas fa-truck"></i> Dalam Pengiriman</span>';
        }else if ($status == 7) {
            return '<span class="badge bg-success"><i class="fas fa-user-check"></i> Telah diserahkan ke konsumen</span>';
        }else if ($status == 8) {
            return '<span class="badge bg-success"><i class="fas fa-user-check"></i> Sudah diterima, menunggu pembayaran</span>';
        }
    }
    function colorStatus($status){
        if($status == 0){
            return 'danger';
        }else if ($status == 1) {
            return 'warning';
        }else if ($status == 2) {
            return 'info';
        }else if ($status == 3) {
            return 'info';
        }else if ($status == 4) {
            return 'success';
        }else if ($status == 6) {
            return 'success';
        }else if ($status == 7) {
            return 'success';
        }else if ($status == 8) {
            return 'success';
        }
    }
    function cekStatusHarga($id){
        $pemesanan = Pemesanan::find($id);
        $cekHarga = 0;
        foreach ($pemesanan->PemesananDetail as $item) {
            if ($item->harga_jual == null or $item->harga_jual == 0 or $item->status_barang == 2) {
                $cekHarga++;
            }
        }
        return $cekHarga;
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
    public function UNIQUE_KODE(){
        $ts = strtotime(NOW());
        $first_day_this_month = date('Y-m-01 00:00:00',$ts);
        $last_day_this_month  = date('Y-m-t 23:59:59',$ts);
        $servisan = Pemesanan::where('id_user',auth()->user()->id)->whereBetween('created_at', array($first_day_this_month, $last_day_this_month))->get();
        $totalUser = str_pad(COUNT($servisan)+1, 3, '0', STR_PAD_LEFT);
        $today = date("dmy");
        return "0".auth()->user()->id."/".$totalUser."/".$today;
    } 

    public function PemesananDetail()
    {
        return $this->hasMany(PemesananDetail::class, 'id_pemesanan', 'id');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

}
