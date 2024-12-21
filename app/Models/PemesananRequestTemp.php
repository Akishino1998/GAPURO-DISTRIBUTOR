<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananRequestTemp extends Model
{
    use HasFactory;
    public $table = 'pemesanan_request_temp';
    protected $dates = ['deleted_at'];

}
