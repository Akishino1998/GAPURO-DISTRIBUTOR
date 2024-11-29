<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangHargaTemp extends Model
{
    use HasFactory;
    public $table = 'barang_harga_fix_term';
    public function Barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }
    public function Admin(){
        return $this->belongsTo(User::class, 'id_admin', 'id');
    }
    public function Toko(){
        return $this->belongsTo(Toko::class, 'id_toko', 'id');
    }
    public function Satuan(){
        return $this->belongsTo(BarangSatuan::class, 'satuan', 'id');
    }

}
