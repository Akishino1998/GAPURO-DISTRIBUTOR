<?php

namespace App\Http\Livewire\Laporan;

use App\Models\Invoice;
use Livewire\Component;

class LabaRugi extends Component
{
    public $time_start, $time_end;

    public function set_date($time_start,$time_end){
        $this->time_start = date("Y-m-d 00:00:00", strtotime($time_start));;
        $this->time_end = date("Y-m-d 23:59:59", strtotime($time_end));
    }
    public function mount(){
        $this->time_start = date("Y-m-01 00:00:00", strtotime(NOW()));
        $this->time_end = date("Y-m-t 23:59:59", strtotime(NOW()));
    }
    public function render()
    {
        $invoice = Invoice::latest()->where('status',3)->whereBetween('tgl_bayar',[$this->time_start,$this->time_end])->get();
        return view('livewire.laporan.laba-rugi',compact('invoice'));
    }
}
