<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Bank extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'ref_bank';
    protected $dates = ['deleted_at'];

}
