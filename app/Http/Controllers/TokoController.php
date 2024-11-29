<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TokoController extends Controller
{
    function index(){
        return view('toko.index');
    }
    function create(){
        return view('toko.create');
    }
    function store(Request $request){
        $validated = $request->validate([
            'email' => ['required', 'unique:users'],
            'name' => ['required'],
            'nama_toko' => ['required'],
        ],
        [
            'email.required' => 'Harus Diisi!',
            'name.required' => 'Harus Diisi!',
            'nama_toko.required' => 'Harus Diisi!',
            'email.unique' => 'Sudah digunakan!',
        ]);

        $user = new User;
        $user->id_role = 3;
        $user->name = $request->name;
        $user->password = Hash::make(12345678);
        $user->email =  $request->email;
        $user->save();

        $toko= new Toko;
        $toko->id_user = $user->id;
        $toko->id_admin = Auth::user()->id;
        $toko->nama_toko = $request->nama_toko;
        $toko->save();

        return redirect(route('toko.index'));
    }
    function show($id){
        $toko = Toko::find($id);
        return view('toko.show',compact('toko'));
    }
}
