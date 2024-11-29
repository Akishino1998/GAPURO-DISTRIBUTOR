<?php
namespace App\Http\Livewire\Pemesanan;

use App\Models\Pemesanan;
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
    function setujuiBarang(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 1;
        $pemesanan->save();
        session()->flash('message-success', "Data berhasil diubah!");
    }
    function pesananDiterima(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 8;
        $pemesanan->save();
        session()->flash('message-success', "Data berhasil diubah!");
    }
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        return view('livewire.pemesanan.proses',compact('pemesanan'));
    }
}
