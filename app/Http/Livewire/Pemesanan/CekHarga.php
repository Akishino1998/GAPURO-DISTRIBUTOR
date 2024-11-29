<?php

namespace App\Http\Livewire\Pemesanan;

use App\Models\PemesananDetail;
use Livewire\Component;

class CekHarga extends Component
{
    public $pemesanan;
    public $barangSelect ;
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    function setStatusBarang($id){
        $this->barangSelect = PemesananDetail::find($id);
    }
    function editStatusBarang(){
        $barang = PemesananDetail::find($this->barangSelect->id);
        $barang->status_barang_user =  ($barang->status_barang_user == 1)?2:1;
        $barang->save();
        $this->barangSelect = "";
        session()->flash('message-success', "Status barang diubah!");
    }
    public function render()
    {
        return view('livewire.pemesanan.cek-harga');
    }
}
