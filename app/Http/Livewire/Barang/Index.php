<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $limitPerPage = 30, $nama_barang ="";
    protected $listeners = [
        'loadMore'
    ];
    public function loadMore()
    {
        $this->limitPerPage = $this->limitPerPage + 30;
    }
    public function render()
    {
        $barang = Barang::latest()->where('alt_barang',"LIKE","%".$this->nama_barang."%")->paginate($this->limitPerPage);
        return view('livewire.barang.index',compact('barang'));
    }
}
