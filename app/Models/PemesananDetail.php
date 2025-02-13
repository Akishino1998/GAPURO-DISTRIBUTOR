<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemesananDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'pemesanan_detail';
    protected $dates = ['deleted_at'];
    public function Barang()
    {
        return $this->belongsTo(\App\Models\Barang::class, 'id_barang')->withTrashed();
    }
    public function Satuan()
    {
        return $this->belongsTo(\App\Models\BarangSatuan::class, 'id_satuan')->withTrashed();
    }
    public function Penyiapan()
    {
        return $this->hasMany(PemesananDetailPenyiapan::class, 'id_pemesanan_detail', 'id');
    }
}
