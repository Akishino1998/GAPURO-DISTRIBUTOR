<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangHargaTemp;
use App\Models\BarangSatuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KonsumenController extends Controller
{
    function index(){
        return view('konsumen.index');
    }
    function create(){
        return view('konsumen.create');
    }
    function store(Request $request){
        $validated = $request->validate([
            'email' => ['required', 'unique:users'],
            'name' => ['required'],
        ],
        [
            'email.required' => 'Harus Diisi!',
            'name.required' => 'Harus Diisi!',
            'email.unique' => 'Sudah digunakan!',
        ]);
        $user = new User;
        $user->id_role = 5;
        $user->name = $request->name;
        $user->password = Hash::make(12345678);
        $user->email =  $request->email;
        $user->save();
        return redirect(route('konsumen.index'));

    }
    function harga($id){
        $konsumen = User::find($id);
        return view('konsumen.harga',compact('konsumen'));
    }
    function setHarga($id){
        $konsumen = User::find($id);
        return view('konsumen.setHarga', compact('konsumen'));
    }
}
