<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Toko extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;
    public $table = 'toko';
    protected $dates = ['deleted_at'];
    public function sluggable(): array
    {
        return [
            'slug_toko' => [
                'source' => 'nama_toko'
            ]
        ];
    }
    function PemilikToko(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

}
