<?php

namespace App\Http\Livewire\Admin\Pemesanan;

use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Livewire\Component;

class Proses extends Component
{
    public $pemesanan;
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    function batalkanPemesanan(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 0;
        $pemesanan->save();
        session()->flash('message-success', "Data berhasil diubah!");
    }
    function kirimPenawaran(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 3;
        $pemesanan->save();
        session()->flash('message-success', "Data berhasil diubah!");
    }
    function mulaiPembelian(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 4;
        $pemesanan->save();
        session()->flash('message-success', "Data berhasil diubah!");
    }
    function mulaiPengiriman(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 6;
        $pemesanan->save();
        session()->flash('message-success', "Data berhasil diubah!");
    }
    public $harga_modal_total, $barangSelect;
    function setEditHarga($id){
        $this->harga_modal_total = "";
        $this->barangSelect = PemesananDetail::find($id);
        $this->harga_modal_total = number_format($this->barangSelect->harga_modal_total, 0, ",", ".");
    }
    function editHarga(){
        $request = $this->validate([
            'harga_modal_total' => 'required',
        ]);
        if ($this->harga_modal_total == 0) {
            session()->flash('message-failed', "Tidak boleh kosong!");
        }else{
            $barang = PemesananDetail::find($this->barangSelect->id);
            $barang->harga_modal_per_satuan =  ($this->harga_modal_total == "")?0:str_replace(".","",$this->harga_modal_total)/$barang->qty;
            $barang->harga_modal_total =  (($this->harga_modal_total == "")?0:str_replace(".","",$this->harga_modal_total));
            $barang->status_tersedia = 2;
            $barang->save();
            $this->barangSelect = "";
            session()->flash('message-success', "Data berhasil diubah!");
        }
    }
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        return view('livewire.admin.pemesanan.proses',compact('pemesanan'));
    }
}
