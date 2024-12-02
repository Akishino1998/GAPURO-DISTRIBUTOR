<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(){
        $time_start =  date("Y-m-01 00:00:00", strtotime(NOW()));
        $time_end = date("Y-m-t 23:59:59", strtotime(NOW()));
        $pemesanan = Pemesanan::latest()->where('id_user',auth()->user()->id)->whereBetween('tgl_pemesanan',[$time_start,$time_end])->get();
        if (auth()->user()->id_role == 1) {
            $pemesanan = Pemesanan::latest()->whereBetween('tgl_pemesanan',[$time_start,$time_end])->get();
        }
        return view('home',compact('pemesanan'));
    }
}
