<?php

namespace App\Http\Livewire\Pemesanan;

use App\Models\PemesananDetail;
use App\Models\PemesananTambahan;
use Livewire\Component;

class CekHarga extends Component
{
    public $pemesanan;
    public $barangSelect,$stat,$setujui ;
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    function setStatusBarang($id,$stat,$setujui){
        $this->stat = $stat;
        $this->setujui = $setujui;
        if ($stat == 1) {
            $this->barangSelect = PemesananDetail::find($id);
        } else {
            $this->barangSelect = PemesananTambahan::find($id);
        }
        
    }
    
    function editStatusBarang(){
        if ($this->stat == 1) {
            $barang = PemesananDetail::find($this->barangSelect->id);
            $barang->status_barang_user =  ($this->setujui == 1)?1:2;
            if ($this->setujui == 1) {
                $barang->tgl_harga_acc = NOW();
            }
            $barang->save();
            $this->barangSelect = "";
        } else {
            $barang = PemesananTambahan::find($this->barangSelect->id);
            $barang->status_ditambahkan =  ($this->setujui == 1)?2:3;
            $barang->save();
            $this->barangSelect = "";
        }
        session()->flash('message-success', "Status barang diubah!");
    }
    function setResetStatusBarang($id,$stat){
        $this->stat = $stat;
        if ($stat == 1) {
            $this->barangSelect = PemesananDetail::find($id);
        } else {
            $this->barangSelect = PemesananTambahan::find($id);
        }
    }
    function resetStatusBarang(){
        if ($this->stat == 1) {
            $barang = PemesananDetail::find($this->barangSelect->id);
            $barang->status_barang_user =  ($barang->status_barang_user == 1)?2:1;
            $barang->tgl_harga_acc = null;
            $barang->save();
            $this->barangSelect = "";
        } else {
            $barang = PemesananTambahan::find($this->barangSelect->id);
            $barang->status_ditambahkan =  1;
            $barang->save();
            $this->barangSelect = "";
        }
        session()->flash('message-success', "Status barang diubah!");
    }
    function addPesananTambahan(){
        foreach ($this->pemesanan->PemesananTambahan as $item) {
            if ($item->status_ditambahkan == 2) {
                $barang = new PemesananDetail;
                $barang->status_barang = 1;
                $barang->status_barang_user = 1;
                $barang->status_tersedia = 1;
                $barang->status_diterima = 2;
                $barang->status_request = 2;
                $barang->status_diajukan = 2;
                $barang->tgl_harga_acc = NOW();
                $barang->id_pemesanan = $this->pemesanan->id;
                $barang->id_barang = $item->id_barang;
                $barang->id_satuan = $item->id_satuan;
                $barang->qty = $item->qty;
                $barang->nama_barang = $item->nama_barang;
                $barang->alt_barang = $item->alt_barang;
                $barang->keterangan = $item->keterangan;
                $barang->harga_jual = $item->harga_jual;
                $barang->harga_per_satuan = $item->harga_per_satuan;
                $barang->id_harga_fix = $item->id_harga_fix;
                $barang->save();
            }
            $item->status_pemesanan = 2;
            $item->save();
        }
        session()->flash('message-success', "Status barang diubah!");
    }
    public function render()
    {
        return view('livewire.pemesanan.cek-harga');
    }
}
