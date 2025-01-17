<?php

namespace App\Http\Livewire\Admin\Invoice;

use App\Models\Invoice;
use Livewire\Component;

class Index extends Component
{
    public $time_start, $time_end;
    public $limitPerPage = 30;
    public $idInvoice;
    public $jenis_transaksi = 0;
    public function loadMore()
    {
        $this->limitPerPage = $this->limitPerPage + 30;
    }
    public function mount(){
        $this->time_start = date("Y-m-01 00:00:00", strtotime(NOW()));
        $this->time_end =date("Y-m-t 23:59:59", strtotime(NOW()));
    }
    public function set_date($time_start,$time_end){
        $this->time_start =  date("Y-m-d", strtotime($time_start));
        $this->time_end = date("Y-m-d", strtotime($time_end));
    }
    public function render()
    {
        $invoice = Invoice::latest()->whereBetween('tgl_terbit',[$this->time_start,$this->time_end])->paginate($this->limitPerPage);
        return view('livewire.admin.invoice.index',compact('invoice'));
    }
}
