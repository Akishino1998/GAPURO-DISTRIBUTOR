<?php

namespace App\Http\Livewire\Konsumen;

use App\Models\Barang;
use App\Models\BarangHargaFix;
use App\Models\BarangSatuan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Harga extends Component
{
    public $konsumen;
    public $limitPerPage = 30;
    public function mount($konsumen){
        $this->konsumen = $konsumen;
    }
    public function loadMore()
    {
        $this->limitPerPage = $this->limitPerPage + 25;
    }
    public $idBarang, $qty, $idSatuan, $harga, $keterangan, $namaBarang;
    function resetItem(){
        $this->idBarang = "";
        $this->qty = "";
        $this->idSatuan = "";
        $this->harga = "";
        $this->keterangan = "";
    }
    public $barangSelect;
    function setEditBarang($idBarangSelect){
        $this->barangSelect = BarangHargaFix::find($idBarangSelect);
        $this->namaBarang = $this->barangSelect->Barang->nama_barang;
        $this->idBarang = $this->barangSelect->id;
        $this->qty = $this->barangSelect->qty;
        $this->idSatuan = $this->barangSelect->id_satuan;
        $this->harga = $this->barangSelect->harga;
        $this->harga = $this->barangSelect->harga_jual;
        $this->keterangan = $this->barangSelect->keterangan;
    }
    function simpanDataBarang(){
        $request = $this->validate([
            'qty' => 'required',
            'idSatuan' => 'required',
            'harga' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $barangFix = BarangHargaFix::find($this->idBarang);
            $barangFix->id_admin = auth()->user()->id;
            $barangFix->qty = $this->qty;
            $barangFix->id_satuan = $this->idSatuan;
            $barangFix->harga_jual =  ($this->harga == "")?0:str_replace(".","",$this->harga);
            $barangFix->keterangan = $this->keterangan;
            $barangFix->save();
            $this->resetItem();
            session()->flash('message-success', "Data berhasil ditambahkan!");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('message-failed', "Gagal menambahkan data, ada kesalahan coba reload halaman ini!");
        }
    }
    function removeItemBarang($id){
        BarangHargaFix::find($id)->delete();
        session()->flash('message-success', "Data berhasil dihapus!");
    }
    public $search;
    public function render()
    {
        $barang = Barang::get();
        $satuan = BarangSatuan::get();
        $barangFix = BarangHargaFix::where('id_konsumen',$this->konsumen->id);
        if ($this->search != null) {
            $barangFix = $barangFix->whereHas('Barang', function($query) {
                $query->where('alt_barang','LIKE', "%".$this->search."%");
            });
        }
        $barangFix = $barangFix->get();
        return view('livewire.konsumen.harga',compact('barangFix','barang','satuan'));
    }
}
