<?php

namespace App\Http\Livewire;

use App\Models\Pemesanan;
use Livewire\Component;

class NotifPesananBaru extends Component
{
    public function render()
    {
        $pemesanan = Pemesanan::where('stat_new',1)->get();
        return view('livewire.notif-pesanan-baru',compact('pemesanan'));
    }
}
