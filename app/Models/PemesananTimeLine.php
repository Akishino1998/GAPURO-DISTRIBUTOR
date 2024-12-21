<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananTimeLine extends Model
{
    use HasFactory;
    public $table = 'pemesanan_timeline';
    protected $dates = ['deleted_at'];
    function statusIcon($status){
        if($status == 0){
            return '<i class="fas fa-times bg-'.$this->statusColor($status).'"></i>';
        }else if ($status == 1) {
            return '<i class="fas fa-spinner fa-spin bg-'.$this->statusColor($status).'"></i>';
        }else if ($status == 2) {
            return '<i class="fas fa-file-signature bg-'.$this->statusColor($status).'"></i>';
        }else if ($status == 3) {
            return '<i class="fas fa-file-signature bg-'.$this->statusColor($status).'"></i>';
        }else if ($status == 4) {
            return '<i class="fas fa-truck-loading bg-'.$this->statusColor($status).'"></i>';
        }else if ($status == 5) {
            return '<i class="fas fa-truck-loading bg-'.$this->statusColor($status).'"></i>';
        }else if ($status == 6) {
            return '<i class="fas fa-truck bg-'.$this->statusColor($status).'"></i>';
        }else if ($status == 7) {
            return '<i class="fas fa-user-check bg-'.$this->statusColor($status).'"></i>';
        }else if ($status == 8) {
            return '<i class="fas fa-user-check bg-'.$this->statusColor($status).'"></i>';
        }
    }
    function statusText($status){
        if($status == 0){
            return 'Dibatalkan';
        }else if ($status == 1) {
            return 'Belum Diproses';
        }else if ($status == 2) {
            return 'Pengajuan Harga';
        }else if ($status == 3) {
            return 'Penawaran Harga';
        }else if ($status == 4) {
            return 'Pesanan Sedang Disiapkan';
        }else if ($status == 5) {
            return 'Sudah Sampai';
        }else if ($status == 6) {
            return 'Dalam Pengiriman';
        }else if ($status == 7) {
            return 'Telah diserahkan ke konsumen';
        }else if ($status == 8) {
            return 'Sudah diterima, menunggu pembayaran';
        }
    }
    function statusColor($status){
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
        }else if ($status == 5) {
            return 'success';
        }else if ($status == 6) {
            return 'primary';
        }else if ($status == 7) {
            return 'success';
        }else if ($status == 8) {
            return 'success';
        }
    }
}
