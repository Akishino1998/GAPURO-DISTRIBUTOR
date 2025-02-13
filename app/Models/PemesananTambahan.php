<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemesananTambahan extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'pemesanan_tambahan';
    protected $dates = ['deleted_at'];
    public function Barang()
    {
        return $this->belongsTo(\App\Models\Barang::class, 'id_barang')->withTrashed();
    }
    public function Satuan()
    {
        return $this->belongsTo(\App\Models\BarangSatuan::class, 'id_satuan')->withTrashed();
    }
    function statusTambahan($status){
        if($status == 1){
            return '<span class="badge bg-warning"><i class="fas fa-spinner fa-spin"></i> Menunggu Verifikasi</span>';
        }else if ($status == 2) {
            return '<span class="badge bg-success"><i class="fas fa-check-double"></i> Sudah Ditambahkan</span>';
        }else if ($status == 3) {
            return '<span class="badge bg-danger"><i class="fas fa-times"></i> Tidak ada</span>';
        }
    }
}
