<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    function index(){
        return view('pemesanan.index');
    }
    function create(){
        return view('pemesanan.create');
    }
    function show($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('pemesanan.index'));
        }
        return view('pemesanan.show',compact('pemesanan'));
    }
    function cekHarga($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('pemesanan.index'));
        }
        return view('pemesanan.cekHarga',compact('pemesanan'));
    }
}