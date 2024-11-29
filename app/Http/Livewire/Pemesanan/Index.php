<?php

namespace App\Http\Livewire\Pemesanan;

use App\Models\Pemesanan;
use Livewire\Component;

class Index extends Component
{
    public $limitPerPage = 50;
    public function loadMore()
    {
        $this->limitPerPage = $this->limitPerPage + 25;
    }
    public function render()
    {
        $pemesanan = Pemesanan::latest()->where('id_user',auth()->user()->id)->get();
        return view('livewire.pemesanan.index',compact('pemesanan'));
    }
}
