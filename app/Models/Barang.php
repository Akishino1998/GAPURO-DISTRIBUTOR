<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'barang';
    protected $dates = ['deleted_at'];

    public function Kategori()
    {
        return $this->belongsTo(\App\Models\BarangKategori::class, 'id_kategori')->withTrashed();
    }
    public function Merk()
    {
        return $this->belongsTo(\App\Models\BarangMerk::class, 'id_merk')->withTrashed();
    }
    public function Satuan()
    {
        return $this->belongsTo(\App\Models\BarangSatuan::class, 'id_satuan')->withTrashed();
    }
}
