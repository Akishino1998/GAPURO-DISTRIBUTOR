<?php

namespace App\Http\Livewire\Pemesanan;

use App\Models\Pemesanan;
use Livewire\Component;

class Show extends Component
{
    public $pemesanan;
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        return view('livewire.pemesanan.show',compact('pemesanan'));
    }
}
