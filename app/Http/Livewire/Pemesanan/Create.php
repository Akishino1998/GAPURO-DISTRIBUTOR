<?php

namespace App\Http\Livewire\Pemesanan;

use App\Models\Barang;
use App\Models\BarangHargaFix;
use App\Models\BarangSatuan;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\PemesananDetailTemp;
use App\Models\PemesananRequest;
use App\Models\PemesananRequestTemp;
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
            $this->qty_pemesanan = "";
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
    protected $messages = [
        'qty_pemesanan.required' => 'Pemesanan harus diisi, ya!',
        'idBarang.required' => 'Barang harus diisi, ya!',
        'nama_barang_request.required' => 'Barang harus diisi, ya!',
        'qty_pemesanan.min' => 'Minimal pemesanan tidak boleh kosong!',
        'qty_request.min' => 'Minimal pemesanan tidak boleh kosong!',
        'qty_request.required' => 'Pemesanan harus diisi, ya!',

    ];
    function tambahPesanan(){
        $request = $this->validate([
            'qty_pemesanan' => 'required|min:1|not_in:0|numeric',
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
        DB::beginTransaction();
        try {
            $tempBarang = PemesananDetailTemp::where('id_user',auth()->user()->id)->get();
            $tempRequest = PemesananRequestTemp::where('id_user',auth()->user()->id)->get();
            if (COUNT($tempBarang)==0 && COUNT($tempRequest) ==0) {
                session()->flash('message-failed', "Pilih Barang terlebih dahulu!");
                return 0;
            }
    
            $pemesanan = new Pemesanan;
            $pemesanan->nomor_pesanan =  $pemesanan->UNIQUE_KODE();
            if ( $this->statusHarga == 1) {
                $pemesanan->status_harga =  1; //sudah ada harga
                $pemesanan->status =  1;
            }else{
                $pemesanan->status_harga =  2; //belum ada harga
                $pemesanan->status = 2;
            }
            $pemesanan->id_user =  auth()->user()->id;
            $pemesanan->tgl_pemesanan = NOW();
            $pemesanan->save();
            foreach ($tempBarang as $item) {
                $barangTemp = new PemesananDetail;
                $barangTemp->id_pemesanan = $pemesanan->id;
                $barangTemp->id_barang = $item->id_barang;
                $barangTemp->id_satuan = ($item->id_harga_fix==null)?$item->Satuan->id:$item->barangHargaFix->Satuan->id;
                $barangTemp->qty = $item->qty;
                $barangTemp->nama_barang = $item->nama_barang;
                $barangTemp->keterangan = ($item->id_harga_fix==null)?$item->keterangan:$item->barangHargaFix->keterangan;
                $barangTemp->harga_jual = $item->harga_jual;
                $barangTemp->harga_per_satuan = $item->harga_jual;
                $barangTemp->id_harga_fix = $item->id_harga_fix;
                $barangTemp->save();
                $item->delete();
            }
            foreach ($tempRequest as $item) {
                $barangTemp = new PemesananRequest;
                $barangTemp->id_pemesanan = $pemesanan->id;
                $barangTemp->qty = $item->qty;
                $barangTemp->nama_barang = $item->nama_barang;
                $barangTemp->save();
                $item->delete();
            }
            $pemesanan->setTimelinePemesanan($pemesanan->id);
            session()->flash('message-success', "Data berhasil ditambahkan!");
            DB::commit();
            return redirect(route('pemesanan.index'));
        } catch (\Exception $e) {
            session()->flash('message-failed', "Ada kesalahan, silahkan reload halaman ini!");
            DB::rollback();
        }
    }
    // function 
    function removeItemBarang($id){
        DB::beginTransaction();
        try {
            PemesananDetailTemp::find($id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }   
    // function 
    function removeItemBarangRequest($id){
        DB::beginTransaction();
        try {
            PemesananRequestTemp::find($id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }   

    public $nama_barang_request, $qty_request;
    function tambahRequestPesanan(){
        $request = $this->validate([
            'qty_request' => 'required|min:1|not_in:0',
            'nama_barang_request' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $pesananReq = new PemesananRequestTemp;
            $pesananReq->id_user = auth()->user()->id;
            $pesananReq->nama_barang = $this->nama_barang_request;
            $pesananReq->qty = $this->qty_request;
            $pesananReq->save();
            DB::commit();
            session()->flash('message-success', "Data berhasil ditambahkan!");
            $this->nama_barang_request = "";
            $this->qty_request = "";
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('message-failed', "Ada kesalahan, silahkan reload halaman ini!");
        }
    }
    public function render()
    {
        $barang = Barang::get();
        $barangHargaFix = BarangHargaFix::where('id_konsumen',auth()->user()->id)->get();
        $tempBarang = PemesananDetailTemp::where('id_user',auth()->user()->id)->get();
        $tempBarangRequest = PemesananRequestTemp::where('id_user',auth()->user()->id)->get();
        return view('livewire.pemesanan.create', compact('barang','tempBarang','barangHargaFix','tempBarangRequest'));
    }
}
