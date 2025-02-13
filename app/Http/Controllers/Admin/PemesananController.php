<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    function index(){
        return view('admin.pemesanan.index');
    }
    function show($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        $pemesanan->stat_new = 2;
        $pemesanan->save();
        return view('admin.pemesanan.proses',compact('pemesanan'));
    }
    function setHarga($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        return view('admin.pemesanan.setHarga',compact('pemesanan'));
    }
    function request($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        return view('admin.pemesanan.request',compact('pemesanan'));
    }
    function menyiapkan($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        return view('admin.pemesanan.menyiapkan',compact('pemesanan'));
    }
    function menyiapkanPrint($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        return view('admin.pemesanan.menyiapkanPrint',compact('pemesanan'));
    }
    function penerimaan($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        return view('admin.pemesanan.penerimaan',compact('pemesanan'));
    }
    function invoice($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan->Invoice == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        return view('admin.pemesanan.invoice',compact('pemesanan'));
    }
    function invoiceSimpan(Request $request, $id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan->Invoice == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        $invoice = $pemesanan->Invoice;
        $invoice->status = 2;
        $invoice->penerima = $request->penerima;
        $invoice->tgl_tempo = $request->tgl_tempo;
        $invoice->save();
        return redirect(route('admin.pemesanan.invoice',$pemesanan->id));
    }
    function invoiceBayar($id){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan->Invoice == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        $pemesanan->status = 9;
        $pemesanan->save();
        $invoice = $pemesanan->Invoice;
        $invoice->status = 3;
        $invoice->tgl_bayar = NOW();
        $invoice->save();
        return redirect(route('admin.pemesanan.invoice',$pemesanan->id));
    }
    function invoicePrint( $id ){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan->Invoice == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        return view('pemesanan.print',compact('pemesanan'));
    }
    function invoiceDownload( $id ){
        $pemesanan = Pemesanan::find($id);
        if ($pemesanan->Invoice == null) {
            return redirect(route('admin.pemesanan.index'));
        }
        return view('pemesanan.pdf',compact('pemesanan'));
        
        $pdf = PDF::loadView('pemesanan.pdf',compact('pemesanan'));
        return $pdf->download('INVOICE-'.$pemesanan->Invoice->no_invoice.'-'.now().'.pdf');
    }
}
