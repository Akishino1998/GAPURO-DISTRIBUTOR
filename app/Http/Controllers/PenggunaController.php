<?php

namespace App\Http\Controllers;

use App\Models\AuthRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;

class PenggunaController extends Controller
{
    function index(){
        $user = User::whereIn('id_role',[2,3,4,5,6,7])->get();
        return view('admin.pengguna.index',compact('user'));
    }
    public function create()
    {
        $role = AuthRole::pluck('role','id');
        return view('admin.pengguna.create',compact('role'));
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validated = $request->validate([
            'email' => 'required|unique:users|email',
            'name' => 'required',
            'password' => 'required|min:8',
        ],
        [
            'email.required' => 'Email wajib diisi!',
            'email.unique' => 'Email telah digunakan!',
            'password.unique' => 'Password Wajib diisi!',
            'password.min' => 'Minimal Password 8 karakter!',
        ]);
        $user = new User;
        if (in_array($request->role,[1,2,3,4,5,6,7])) {
            $pengguna = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'id_role' => $request->role,
                'password' => Hash::make($request->password),
            ]);
        }else{
            Flash::error('Pengguna tidak diketahui!');
            return redirect(route('admin.master.user.index'));
        }
        Flash::success('Pengguna berhasil disimpan.');
        return redirect(route('admin.master.user.index'));
    }
    public function destroy($id)
    {
        $pengguna = User::find($id);
        if (empty($pengguna)) {
            Flash::error('Tidak ditemukan');
            return redirect(route('admin.master.user.index'));
        }
        if ($pengguna->set_aktif_toko != Auth::user()->set_aktif_toko) {
            Flash::error('Tidak ditemukan');
            return redirect(route('admin.master.user.index'));
        }
        if ($pengguna->non_aktif == null) {
            $pengguna->non_aktif = NOW();
            Flash::success('User berhasil dinonaktifkan.');
        }else{
            $pengguna->non_aktif = null;
            Flash::success('User berhasil diaktifkan kembali.');
        }
        $pengguna->save();
        return redirect(route('admin.master.user.index'));
    }
  
}
