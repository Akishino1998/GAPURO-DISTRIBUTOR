<?php

namespace App\Http\Livewire\Admin\Pemesanan;

use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Livewire\Component;

class Penerimaan extends Component
{
    public $pemesanan;
    public $barangSelect, $qty_pesanan, $satuan;
    protected $listeners = ['editStatusBarang'];
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    function setEditHarga($id){
        $this->barangSelect = PemesananDetail::find($id);
        $this->qty_pesanan = ($this->barangSelect->qty_diterima==null)?$this->barangSelect->qty:$this->barangSelect->qty_diterima;
        $this->satuan = $this->barangSelect->Satuan->satuan;
    }
    function editStatusBarang(){
        $barang = PemesananDetail::find($this->barangSelect->id);
        $barang->status_diterima =  2;
        $barang->qty_diterima = $this->qty_pesanan;
        $barang->tgl_diterima = NOW();
        $barang->save();
        $this->barangSelect = "";
        session()->flash('message-success', "Status barang diubah!");
    }
    function penerimaanBarang(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 8;
        $pemesanan->save();
        $pemesanan->setTimelinePemesanan($pemesanan->id);
        session()->flash('message-success', "Data berhasil diubah!");
        return redirect(route('admin.pemesanan.show',$pemesanan->id));
    }
    
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        return view('livewire.admin.pemesanan.penerimaan',compact('pemesanan'));
    }
}
