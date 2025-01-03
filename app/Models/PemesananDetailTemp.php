<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemesananDetailTemp extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'pemesanan_detail_temp';
    protected $dates = ['deleted_at'];
    public function Barang()
    {
        return $this->belongsTo(\App\Models\Barang::class, 'id_barang')->withTrashed();
    }
    public function Satuan()
    {
        return $this->belongsTo(\App\Models\BarangSatuan::class, 'id_satuan')->withTrashed();
    }
    function barangHargaFix()
    {
        return $this->belongsTo(\App\Models\BarangHargaFix::class, 'id_harga_fix')->withTrashed();
    }

}
