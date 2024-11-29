<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BarangKategori
 * @package App\Models
 * @version October 21, 2024, 8:26 am UTC
 *
 * @property integer $id_toko
 * @property string $kode
 * @property string $kategori
 */
class BarangKategori extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'barang_kategori';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'id_toko',
        'kode',
        'kategori'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'id_toko' => 'integer',
        'kode' => 'string',
        'kategori' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_toko' => 'nullable|integer',
        'kode' => 'nullable|string|max:100',
        'kategori' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
