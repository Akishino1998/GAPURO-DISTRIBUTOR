<?php

namespace App\Http\Livewire;

use App\Models\Pemesanan;
use Livewire\Component;

class ModalPesananBaru extends Component
{
    public $countPemesanan = 0;
    public function render()
    {
        $pemesanan = Pemesanan::where('stat_new',1)->get();
        $this->countPemesanan = COUNT($pemesanan);
        return view('livewire.modal-pesanan-baru',compact('pemesanan'));
    }
}
