<?php

namespace App\Http\Livewire\Konsumen;

use App\Models\Barang;
use App\Models\BarangHargaFix;
use App\Models\BarangHargaTemp;
use App\Models\BarangSatuan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SetHarga extends Component
{
    public $konsumen,$idBarang,$qty,$idSatuan,$harga,$keterangan;
    public function mount($konsumen){
        $this->konsumen = $konsumen;
    }
    function changeBarang($idBarang){
        $this->idBarang = $idBarang;
    }
    function addTambahBarang(){
        $barangTemp = new BarangHargaTemp;
        $barangTemp->id_admin = auth()->user()->id;
        $barangTemp->id_barang = $this->idBarang;
        $barangTemp->id_konsumen = $this->konsumen->id;
        $barangTemp->qty = $this->qty;
        $barangTemp->satuan = $this->idSatuan;
        $barangTemp->harga =  ($this->harga == "")?0:str_replace(".","",$this->harga);
        $barangTemp->keterangan = $this->keterangan;
        $barangTemp->save();

        $this->resetItem();
    }
    function resetItem(){
        $this->idBarang = "";
        $this->qty = "";
        $this->idSatuan = "";
        $this->harga = "";
        $this->keterangan = "";
        $this->statusBarang = false;
    }
    public $statusBarang = false;
    function tambahBarangBaru(){
        $request = $this->validate([
            'idBarang' => 'required',
            'qty' => 'required',
            'idSatuan' => 'required',
            'harga' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $check = BarangHargaTemp::where('id_konsumen',$this->konsumen->id)->where('id_barang', $this->idBarang)->get();
            if (COUNT($check)>0) {
                if($this->statusBarang == false){
                    $this->statusBarang = true;
                    session()->flash('message-warning', "Ada data yang sama!");
                }else{
                    $check->first()->delete();
                    $this->addTambahBarang();
                    session()->flash('message-success', "Data berhasil ditambahkan1!");
                    DB::commit();
                }
            }else{
                $this->addTambahBarang();
                session()->flash('message-success', "Data berhasil ditambahkan!");
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('message-failed', "Gagal menambahkan data, ada kesalahan coba reload halaman ini!");
        }
            
       

    }
    function removeItemBarang($id){
        BarangHargaTemp::find($id)->delete();
        session()->flash('message-success', "Data berhasil dihapus!");
    }
    function tambahDataHargaBarang(){
        $tempBarang = BarangHargaTemp::where('id_konsumen',$this->konsumen->id)->get();
        foreach ($tempBarang as $item) {
            $barangFix = new BarangHargaFix;
            $barangFix->id_admin = $item->id_admin;
            $barangFix->id_barang = $item->id_barang;
            $barangFix->id_konsumen = $item->id_konsumen;
            $barangFix->qty = $item->qty;
            $barangFix->id_satuan = $item->satuan;
            $barangFix->harga_jual =  $item->harga;
            $barangFix->keterangan = $item->keterangan;
            $barangFix->save();
            $item->delete();
        }
        return redirect(route('konsumen.harga',$this->konsumen->id));
    }
    public function render()
    {
        $konsumen = User::find($this->konsumen->id);
        $barang = Barang::get();
        $satuan = BarangSatuan::get();
        $tempBarang = BarangHargaTemp::where('id_konsumen',$this->konsumen->id)->get();
        return view('livewire.konsumen.set-harga', compact('konsumen','barang','satuan','tempBarang'));
    }
}
