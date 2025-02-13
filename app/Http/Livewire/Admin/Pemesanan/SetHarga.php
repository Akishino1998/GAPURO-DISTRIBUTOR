<?php

namespace App\Http\Livewire\Admin\Pemesanan;

use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\PemesananTambahan;
use Livewire\Component;

class SetHarga extends Component
{
    public $pemesanan;
    public $barangSelect,$statEdit,$stat,$status_ditambahkan ;
    protected $listeners = [
        'editHarga'
    ];
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    function setEditHarga($id,$stat){
        $this->harga = "";
        if ($stat == 1) {
            $this->barangSelect = PemesananDetail::find($id);
        }else{
            $this->barangSelect = PemesananTambahan::find($id);
        }
        $this->statEdit = $stat;
        $this->harga = number_format($this->barangSelect->harga_per_satuan, 0, ",", ".");
    }
    public $harga;
    function editHarga(){
        $request = $this->validate([
            'harga' => 'required',
        ]);
        if ($this->statEdit == 1) {
            $barang = PemesananDetail::find($this->barangSelect->id);
            $barang->status_barang = 3;
        }else{
            $barang = PemesananTambahan::find($this->barangSelect->id);
        }
        $barang->status_barang_user =  1;
        $barang->harga_per_satuan =  ($this->harga == "")?0:str_replace(".","",$this->harga);
        $barang->harga_jual =  (($this->harga == "")?0:str_replace(".","",$this->harga))*$barang->qty;
        $barang->save();
        $this->barangSelect = "";
        session()->flash('message-success', "Data berhasil diubah!");
    }
    function kirimPenawaranTambahan(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        foreach($pemesanan->PemesananTambahan->where('status_pemesanan',1) as $item){
            if ($item->id_harga_fix != null AND $item->status_ditambahkan == 2) {
                $barang = new PemesananDetail;
                $barang->status_barang = 3;
                $barang->status_barang_user = 1;
                $barang->status_diterima = 2;
                $barang->status_request = 2;
                $barang->status_diajukan = 2;
                $barang->status_ditambahkan = 2;
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
            $item->status_diajukan = 2;
            $item->save();
        }
        session()->flash('message-success', "Data berhasil diubah!");
    }
    function kirimPenawaran(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 3;
        $pemesanan->save();

        foreach($pemesanan->PemesananDetail as $item){
            $item->status_diajukan = 2;
            $item->save();
        }
        $pemesanan->setTimelinePemesanan($pemesanan->id);

        session()->flash('message-success', "Data  berhasil diubah!");
    }
    function setStatusBarang($id, $stat, $status_ditambahkan){
        $this->status_ditambahkan = $status_ditambahkan;
        if ($stat == 1) {
            $this->barangSelect = PemesananDetail::find($id);
        }else{
            $this->barangSelect = PemesananTambahan::find($id);
        }
        $this->stat = $stat;
    }
    function editStatusBarang(){
        if ($this->stat == 1) {
            $barang = PemesananDetail::find($this->barangSelect->id);
            $barang->status_barang =  $this->status_ditambahkan;
            $barang->save();
        }else{
            $barang = PemesananTambahan::find($this->barangSelect->id);
            $barang->status_ditambahkan = $this->status_ditambahkan;
            $barang->save();
        }
       
        
        $this->barangSelect = "";
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
            $barang->status_barang = 1;
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
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        return view('livewire.admin.pemesanan.set-harga',compact('pemesanan'));
    }
}
