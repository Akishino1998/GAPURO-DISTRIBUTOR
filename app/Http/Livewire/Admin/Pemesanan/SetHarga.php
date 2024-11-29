<?php

namespace App\Http\Livewire\Admin\Pemesanan;

use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Livewire\Component;

class SetHarga extends Component
{
    public $pemesanan;
    public $barangSelect ;
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    function setEditHarga($id){
        $this->harga = "";
        $this->barangSelect = PemesananDetail::find($id);
        $this->harga = number_format($this->barangSelect->harga_per_satuan, 0, ",", ".");
    }
    public $harga;
    function editHarga(){
        $request = $this->validate([
            'harga' => 'required',
        ]);
        $barang = PemesananDetail::find($this->barangSelect->id);
        $barang->harga_per_satuan =  ($this->harga == "")?0:str_replace(".","",$this->harga);
        $barang->harga_jual =  (($this->harga == "")?0:str_replace(".","",$this->harga))*$barang->qty;
        $barang->save();
        $this->barangSelect = "";
        session()->flash('message-success', "Data berhasil diubah!");
    }
    function setStatusBarang($id){
        $this->barangSelect = PemesananDetail::find($id);
    }
    function editStatusBarang(){
        $barang = PemesananDetail::find($this->barangSelect->id);
        $barang->status_barang =  ($barang->status_barang == 1)?2:1;
        $barang->save();
        $this->barangSelect = "";
        session()->flash('message-success', "Status barang diubah!");
    }
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        return view('livewire.admin.pemesanan.set-harga',compact('pemesanan'));
    }
}
