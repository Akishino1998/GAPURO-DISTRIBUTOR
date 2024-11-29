<?php

namespace App\Http\Livewire\Admin\Pemesanan;

use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Livewire\Component;

class Penerimaan extends Component
{
    public $pemesanan;
    public $barangSelect ;
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    function setEditHarga($id){
        $this->barangSelect = PemesananDetail::find($id);
    }
    function editStatusBarang(){
        $barang = PemesananDetail::find($this->barangSelect->id);
        $barang->status_diterima =  ($barang->status_diterima == 1)?2:1;
        $barang->save();
        $this->barangSelect = "";
        session()->flash('message-success', "Status barang diubah!");
    }
    function penerimaanBarang(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 7;
        $pemesanan->save();
        session()->flash('message-success', "Data berhasil diubah!");
        return redirect(route('admin.pemesanan.show',$pemesanan->id));
    }
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        return view('livewire.admin.pemesanan.penerimaan',compact('pemesanan'));
    }
}
