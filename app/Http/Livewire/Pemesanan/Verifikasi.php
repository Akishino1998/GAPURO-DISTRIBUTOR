<?php

namespace App\Http\Livewire\Pemesanan;

use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Livewire\Component;

class Verifikasi extends Component
{
    public $pemesanan;
    public $barangSelect, $qty_pesanan, $satuan;
    protected $listeners = ['setEditHarga'];
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    function setEditHarga($id){
        $this->barangSelect = PemesananDetail::find($id);
        $this->qty_pesanan = ($this->barangSelect->qty_diterima_user==null)?$this->barangSelect->qty:$this->barangSelect->qty_diterima_user;
        $this->satuan = $this->barangSelect->Satuan->satuan;
    }
    function editStatusBarang(){
        $barang = PemesananDetail::find($this->barangSelect->id);
        $barang->status_diterima =  2;
        $barang->qty_diterima_user = $this->qty_pesanan;
        $barang->tgl_diterima_user = NOW();
        $barang->save();
        $this->barangSelect = "";
        session()->flash('message-success', "Status barang diubah!");
    }
    function penerimaanBarang(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->tgl_selesai_konsumen = now();
        $pemesanan->save();
        foreach ($pemesanan->PemesananDetail->where('status_tersedia',2) as $item){
            $item->qty_diterima_user = $item->qty;
            $item->tgl_diterima_user = NOW();
            $item->save();
        }
        session()->flash('message-success', "Data berhasil diubah!");
    }
    function pesananDiterima(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 8;
        $pemesanan->tgl_selesai = NOW();
        $pemesanan->save();

        $pemesanan->setTimelinePemesanan($pemesanan->id);

        session()->flash('message-success', "Data berhasil diubah!");
    }
    
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        return view('livewire.pemesanan.verifikasi',compact('pemesanan'));

    }
}
