<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthRolePermission extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "auth_role_permission";
    protected $dates = ['deleted_at'];
    public function Role()
    {
        return $this->belongsTo(AuthRole::class, 'id_role', 'id');
    }
    public function Permission()
    {
        return $this->belongsTo(AuthPermission::class, 'id_permission', 'id');
    }
}
