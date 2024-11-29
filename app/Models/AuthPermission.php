<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AuthPermission extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "auth_permission";
    protected $dates = ['deleted_at'];
}
