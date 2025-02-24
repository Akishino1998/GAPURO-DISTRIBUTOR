<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'pemesanan_invoice';
    protected $dates = ['deleted_at'];
    public function UNIQUE_KODE(){
        $idToko = Auth::user()->id;
        $ts = strtotime(NOW());
        $first_day_this_month = date('Y-m-01 00:00:00',$ts);
        $last_day_this_month  = date('Y-m-t 23:59:59',$ts);
        $servisan = Invoice::where('id_user',auth()->user()->id)->whereBetween('created_at', array($first_day_this_month, $last_day_this_month))->get();
        $totalUser = str_pad(COUNT($servisan)+1, 3, '0', STR_PAD_LEFT);
        $today = date("dmy");
        return "INV/0".$idToko."/".$totalUser."/".$today;
    } 
    function colorStatus($stat){
        if($stat == 1){
            return 'secondary';
        }elseif($stat == 2){
            return 'info';
        }elseif($stat == 3){
            return 'success';
        }
    }
    public function Konsumen()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function Bank()
    {
        return $this->belongsTo(Bank::class, 'id_bank', 'id');
    }
    public function Pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id');
    }
    function totalInvoice(){
        $invoice = Invoice::whereIn('status',[2,3])->get();
        $totalInvoice = 0;
        foreach ($invoice as $item) {
            foreach ($item->Pemesanan->PemesananDetail->where('status_barang_user',1)->where('tgl_harga_acc',"!=",null) as $value) {
                $totalInvoice+=$value->qty*$value->harga_per_satuan;
            }
        }
        return $totalInvoice;
    }
    function totalInvoiceLunas(){
        $invoice = Invoice::whereIn('status',[3])->get();
        $totalInvoice = 0;
        foreach ($invoice as $item) {
            foreach ($item->Pemesanan->PemesananDetail->where('status_barang_user',1)->where('tgl_harga_acc',"!=",null) as $value) {
                $totalInvoice+=$value->qty*$value->harga_per_satuan;
            }
        }
        return $totalInvoice;
    }
    function totalInvoiceJatuhTempo(){
        $invoice = Invoice::whereIn('status',[2])->where('tgl_tempo',"<",date("Y-m-d H:m:i", strtotime(NOW())))->get();
        $totalInvoice = 0;
        foreach ($invoice as $item) {
            foreach ($item->Pemesanan->PemesananDetail->where('status_barang_user',1)->where('tgl_harga_acc',"!=",null) as $value) {
                $totalInvoice+=$value->qty*$value->harga_per_satuan;
            }
        }
        return $totalInvoice;
    }
    function totalInvoiceBelumJatuhTempo(){
        $invoice = Invoice::whereIn('status',[2])->where('tgl_tempo',">",date("Y-m-d H:m:i", strtotime(NOW())))->get();
        $totalInvoice = 0;
        foreach ($invoice as $item) {
            foreach ($item->Pemesanan->PemesananDetail->where('status_barang_user',1)->where('tgl_harga_acc',"!=",null) as $value) {
                $totalInvoice+=$value->qty*$value->harga_per_satuan;
            }
        }
        return $totalInvoice;
    }
    function totalPerInvoice($id){
        $invoice = Invoice::find($id);
        $totalInvoice = 0;
        foreach ($invoice->Pemesanan->PemesananDetail->where('status_barang_user',1)->where('tgl_harga_acc',"!=",null) as $value) {
            $totalInvoice+=$value->qty*$value->harga_per_satuan;
        }
        return $totalInvoice;
    }
}
