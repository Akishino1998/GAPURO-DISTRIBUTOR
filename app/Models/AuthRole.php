<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthRole extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "auth_role";
    protected $dates = ['deleted_at'];
   
    public function RolePermission(){
        return $this->hasMany(AuthRolePermission::class,'id_role','id')->with('Permission');
    }
}
