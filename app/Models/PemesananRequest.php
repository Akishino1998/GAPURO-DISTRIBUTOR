<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananRequest extends Model
{
    use HasFactory;
    public $table = 'pemesanan_request';
    protected $dates = ['deleted_at'];

    function statusRequest($status){
        if($status == 1){
            return '<span class="badge bg-warning"><i class="fas fa-spinner fa-spin"></i> Menunggu Verifikasi</span>';
        }else if ($status == 2) {
            return '<span class="badge bg-success"><i class="fas fa-check-double"></i> Sudah Ditambahkan</span>';
        }else if ($status == 3) {
            return '<span class="badge bg-danger"><i class="fas fa-times"></i> Tidak ada</span>';
        }
    }
}
