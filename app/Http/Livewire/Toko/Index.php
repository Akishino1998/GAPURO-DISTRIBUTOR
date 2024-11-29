<?php

namespace App\Http\Livewire\Toko;

use App\Models\Toko;
use Livewire\Component;

class Index extends Component
{
    public $limitPerPage = 50;
    public $search;
    public $jenis_pelanggan;
    public function loadMore()
    {
        $this->limitPerPage = $this->limitPerPage + 25;
    }
    public function render()
    {
        $toko = Toko::latest();
        if ($this->search != null) {
            $toko= $toko->where(function ($query) {
                $query->where('nama_toko',"LIKE","%".$this->search."%");
            });
        }
        $countToko = COUNT($toko->get());
        $toko = $toko->paginate($this->limitPerPage);
        return view('livewire.toko.index',compact('toko','countToko'));
    }
}
