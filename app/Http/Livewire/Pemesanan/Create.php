<?php

namespace App\Http\Livewire\Pemesanan;

use App\Models\Barang;
use App\Models\BarangHargaFix;
use App\Models\BarangSatuan;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\PemesananDetailTemp;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $statusBarang;
    public $idBarang, $qty_pemesanan;
    public $namaBarang, $hargaBarang, $kategoriBarang, $keteranganBarang, $satuanBarang;

    public $statusHarga = false;
    public function mount(){
        if(COUNT(BarangHargaFix::where('id_konsumen',auth()->user()->id)->get())>0){
            $this->statusHarga = true;
        }
    }
    function changeBarang($idBarang){
        if ($idBarang!= null) {
            $this->idBarang = $idBarang;
            $barang = Barang::find($idBarang);
            $this->namaBarang = $barang->nama_barang;
            $this->kategoriBarang = '<span class="badge bg-info">'.$barang->Kategori->kategori.'</span> ';
            $this->keteranganBarang = $barang->keterangan;
            $this->satuanBarang = $barang->Satuan->satuan;
            if($this->statusHarga){
                $this->hargaBarang = BarangHargaFix::where('id_konsumen',auth()->user()->id)->where('id_barang',$this->idBarang)->get()->first();
            }
        }
        
    }

    function addTambahBarang(){
        $barang = Barang::find($this->idBarang);
        $barangTemp = new PemesananDetailTemp;
        $barangTemp->id_user = auth()->user()->id;
        $barangTemp->id_barang = $this->idBarang;
        $barangTemp->id_satuan = $barang->id_satuan;
        $barangTemp->qty = $this->qty_pemesanan;
        $barangTemp->nama_barang = $barang->nama_barang;
        if ( $this->statusHarga) {
            $barangTemp->harga_jual = $this->hargaBarang->harga_jual;
            $barangTemp->id_harga_fix = $this->hargaBarang->id;
        }
        $barangTemp->save();

        $this->resetItem();
    }
    function resetItem(){
        // $namaBarang, $hargaBarang, $kategoriBarang, $keteranganBarang, $satuanBarang;
        $this->idBarang = "";
        $this->qty_pemesanan = "";
        $this->namaBarang = "";
        $this->kategoriBarang = "";
        $this->hargaBarang = "";
        $this->keteranganBarang = "";
        $this->satuanBarang = "";
        $this->statusBarang = false;
    }
    function tambahPesanan(){
        $request = $this->validate([
            'qty_pemesanan' => 'required',
            'idBarang' => 'required',
        ]);
       
            $check = PemesananDetailTemp::where('id_user',auth()->user()->id)->where('id_barang', $this->idBarang)->get();
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
       
    }
    function tambahPemesanan(){
        $pemesanan = new Pemesanan;
        $pemesanan->nomor_pesanan =  $pemesanan->UNIQUE_KODE();
        $pemesanan->status =  1;
        if ( $this->statusHarga) {
            $pemesanan->status_harga =  1; //sudah ada harga
        }else{
            $pemesanan->status_harga =  2; //belum ada harga
        }
        $pemesanan->id_user =  auth()->user()->id;
        $pemesanan->tgl_pemesanan = NOW();
        $pemesanan->save();
        $tempBarang = PemesananDetailTemp::where('id_user',auth()->user()->id)->get();
        foreach ($tempBarang as $item) {
            $barangTemp = new PemesananDetail;
            $barangTemp->id_pemesanan = $pemesanan->id;
            $barangTemp->id_barang = $item->id_barang;
            $barangTemp->id_satuan = $item->id_satuan;
            $barangTemp->qty = $item->qty;
            $barangTemp->nama_barang = $item->nama_barang;
            $barangTemp->keterangan = $item->keterangan;
            $barangTemp->harga_jual = $item->harga_jual;
            $barangTemp->id_harga_fix = $item->id_harga_fix;
            $barangTemp->save();
            $item->delete();
        }
        return redirect(route('pemesanan.index'));
    }
    function removeItemBarang($id){
        PemesananDetailTemp::find($id)->delete();
    }
    public function render()
    {
        $barang = Barang::get();
        $barangHargaFix = BarangHargaFix::where('id_konsumen',auth()->user()->id)->get();
        $tempBarang = PemesananDetailTemp::where('id_user',auth()->user()->id)->get();
        return view('livewire.pemesanan.create', compact('barang','tempBarang','barangHargaFix'));
    }
}
