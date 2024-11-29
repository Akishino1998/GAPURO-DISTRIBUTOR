<?php

namespace App\Http\Middleware;

use App\Models\AkNeracaSaldo;
use App\Models\AppsLogs;
use App\Models\AuthPermission;
use App\Models\AuthRolePermission;
use App\Models\Toko;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RolePermission
{
    public function handle(Request $request, Closure $next)
    {   
        // return $next($request);  //delete this if proc  return redirect(route('akuntansi.setup-neraca'));
        $permission = AuthPermission::all()->where('route_name',Route::currentRouteName());
        if ($permission->COUNT()>0) {

            if (Auth::user()->non_aktif != null) {
                session()->flash('msg', 'Akun kamu dinon aktifkan oleh pemilik toko!');
                return redirect('/dashboard');
            }
            $id_role = Auth::user()->id_role;
            $rolePermission = AuthRolePermission::all()->where('id_role',$id_role)->where('id_permission',$permission->first()->id);
            if($rolePermission->COUNT()>0){
                return $next($request); 
            }else{
                session()->flash('msg', 'Kamu tidak boleh mengakses halaman tersebut!');
                return redirect('/dashboard');
            }
        }
        session()->flash('msg', 'Tidak dapat mengakses.');
        return redirect('/dashboard');
    }
}
