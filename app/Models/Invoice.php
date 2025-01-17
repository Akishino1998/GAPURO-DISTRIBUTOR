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
        }elseif($stat == 1){
        }elseif($stat == 1){
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
}
