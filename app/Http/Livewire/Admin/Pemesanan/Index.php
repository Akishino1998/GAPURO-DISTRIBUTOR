<?php

namespace App\Http\Livewire\Admin\Pemesanan;

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
        $pemesanan = Pemesanan::latest()->get();
        if (auth()->user()->id_role == 6) {
            $pemesanan = Pemesanan::latest()->get();
        }
        return view('livewire.admin.pemesanan.index',compact('pemesanan'));
    }
}
