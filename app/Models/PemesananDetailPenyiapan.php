<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemesananDetailPenyiapan extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'pemesanan_detail_penyiapan';
    protected $dates = ['deleted_at'];

}
