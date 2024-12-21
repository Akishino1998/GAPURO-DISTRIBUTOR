<?php

namespace App\Http\Livewire\Admin\Pemesanan;

use App\Models\Barang;
use App\Models\BarangKategori;
use App\Models\BarangMerk;
use App\Models\BarangSatuan;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\PemesananRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Request extends Component
{
    public $pemesanan;
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    public $barangSelect;
    function setStatusBarang($id){
        $this->barangSelect = PemesananRequest::find($id);
    }
    function setVerifikasi($id){
        $this->barangSelect = PemesananRequest::find($id);
    }
    function editStatusBarang(){
        $barang = PemesananRequest::find($this->barangSelect->id);
        $barang->status_request =  ($barang->status_request == 3)?1:3;
        $barang->save();
        $this->barangSelect = "";
        session()->flash('message-success', "Status barang diubah!");
    }
    public $harga_request;
    public $id_kategori,$nama_barang,$id_merk, $id_satuan, $qty_request;
    function verifikasiRequest(){
        $request = $this->validate([
            'harga_request' => 'required',
            'id_kategori' => 'required|exists:barang_kategori,id',
            'id_satuan' => 'required|exists:barang_satuan,id',
            'nama_barang' => 'required',
            'qty_request' => 'required|min:1|not_in:0',
        ]);
        DB::beginTransaction();
        try {
            $barangRequest = PemesananRequest::find( $this->barangSelect->id);
            if ($barangRequest->status_request != 2) {
                $merk = BarangMerk::find($this->id_merk);
                $kategori = BarangKategori::find($this->id_kategori);
                $barang = new Barang;
                $barang->id_admin = Auth::user()->id;
                $barang->id_kategori = $this->id_kategori;
                $barang->id_satuan = $this->id_satuan;
                $barang->id_merk = $this->id_merk;                
                $barang->nama_barang = $this->nama_barang;
                $barang->alt_barang = $merk->first()->merk."".$kategori->first()->kategori." " .$this->nama_barang;
                $barang->save();
        
                $barangTemp = new PemesananDetail;
                $barangTemp->id_pemesanan = $this->pemesanan->id;
                $barangTemp->status_request = 2;
                $barangTemp->id_barang = $barang->id;
                $barangTemp->id_satuan = $barang->id_satuan;
                $barangTemp->qty = $this->qty_request;
                $barangTemp->nama_barang = $barang->nama_barang;
                $barangTemp->harga_jual = ($this->harga_request == "")?0:str_replace(".","",$this->harga_request);
                $barangTemp->harga_per_satuan = $barangTemp->harga_jual/$this->qty_request;
                $barangTemp->save();

                $barangRequest->status_request = 2;
                $barangRequest->save();

            }
            DB::commit();
            session()->flash('message-success', "Data berhasil diubah!");
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('message-failed', "Ada kesalahan, silahkan reload halaman ini!");
        }
        
    }
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $merk = BarangMerk::get();
        $kategori = BarangKategori::get();
        $satuan = BarangSatuan::get();
        return view('livewire.admin.pemesanan.request',compact('pemesanan','merk','kategori','satuan'));
    }
}
