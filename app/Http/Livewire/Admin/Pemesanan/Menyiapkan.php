<?php

namespace App\Http\Livewire\Admin\Pemesanan;

use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\PemesananDetailPenyiapan;
use Livewire\Component;

class Menyiapkan extends Component
{
    public $pemesanan;
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    public $harga_modal_total, $barangSelect, $qty_pemesanan;
    function setEditHarga($id){
        $this->barangSelect = PemesananDetail::find($id);
    }
    protected $messages = [
        'qty_pemesanan.required' => 'Qty harus diisi, ya!',
        'harga_modal_total.required' => 'Harus diisi, ya!',
        'qty_pemesanan.min' => 'Minimal pemesanan tidak boleh kosong!',

    ];
    public $barangDetail;
    function countPembelian($id){
        $qty_total = 0;
        $barangDetail = PemesananDetail::find($id);
        foreach ($barangDetail->Penyiapan as $item) {
            $qty_total += $item->qty;
        }
        if ($qty_total >= $barangDetail->qty) {
            $barang = PemesananDetail::find($barangDetail->id);
            $barang->status_tersedia = 2;
            $barang->save();
        }else{
            $barang = PemesananDetail::find($barangDetail->id);
            $barang->status_tersedia = 1;
            $barang->save();
        }
        $this->barangDetail = $qty_total ." >= ".$barangDetail->qty ;
    }
    function editHarga(){
        $request = $this->validate([
            'harga_modal_total' => 'required',
            'qty_pemesanan' => 'required|min:0.0001|not_in:0|numeric',
        ]);
        if ($this->harga_modal_total == 0) {
            session()->flash('message-failed', "Tidak boleh kosong!");
        }else{
            $barang = new PemesananDetailPenyiapan;
            $barang->id_pemesanan_detail = $this->barangSelect->id;
            $barang->harga_satuan = str_replace(".","",$this->harga_modal_total);
            $barang->qty = $this->qty_pemesanan;
            $barang->tgl_penyiapan = NOW();
            $barang->total_modal = $barang->qty*$barang->harga_satuan;
            $barang->save();

            $this->countPembelian($barang->id_pemesanan_detail);
            
            $this->barangSelect = "";
            $this->harga_modal_total = "";
            $this->qty_pemesanan = "";
            session()->flash('message-success', "Data berhasil diubah!");
        }
    }
    public $selectPembelian;
    function setPembelianBarang($id){
        $this->selectPembelian = $id;
    }
    function removePembelian(){
        $pembelian = PemesananDetailPenyiapan::find($this->selectPembelian);
        $idPemesananDetail = $pembelian->id_pemesanan_detail;
        $pembelian->delete();
        $this->countPembelian($idPemesananDetail);
        session()->flash('message-success-remove', "Data berhasil diubah!");
    }
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        return view('livewire.admin.pemesanan.menyiapkan',compact('pemesanan'));
    }
}
