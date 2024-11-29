<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    function index(){
        return view('admin.pemesanan.index');
    }
    function show($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('pemesanan.index'));
        }
        return view('admin.pemesanan.proses',compact('pemesanan'));
    }
    function setHarga($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('pemesanan.index'));
        }
        return view('pemesanan.setHarga',compact('pemesanan'));
    }
    function penerimaan($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('pemesanan.index'));
        }
        return view('pemesanan.penerimaan',compact('pemesanan'));
    }
}
