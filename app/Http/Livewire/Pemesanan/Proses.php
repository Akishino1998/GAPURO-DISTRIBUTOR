<?php
namespace App\Http\Livewire\Pemesanan;

use App\Models\Bank;
use App\Models\Invoice;
use App\Models\Pemesanan;
use App\Models\PemesananRequest;
use Livewire\Component;

class Proses extends Component
{
    public $pemesanan;
    public function mount($pemesanan){
        $this->pemesanan = $pemesanan;
    }
    function batalkanPemesanan(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 0;
        $pemesanan->save();

        foreach ($pemesanan->PemesananDetail as $item) {
            $item->status_ditambahkan = 2;
            $item->tgl_harga_acc = null;
            $item->save();
        }

        $pemesanan->setTimelinePemesanan($pemesanan->id);

        session()->flash('message-success', "Data berhasil diubah!");
    }
    function kirimPenawaran(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 3;
        $pemesanan->save();

        $pemesanan->setTimelinePemesanan($pemesanan->id);

        session()->flash('message-success', "Data berhasil diubah!");
    }
    function setujuiBarang(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        if($pemesanan->Invoice == null){
            $pemesanan->status = 1;
            $pemesanan->save();
            $pemesanan->setTimelinePemesanan($pemesanan->id);
            $bank = Bank::get()->first();
            $invoice = new Invoice;
            $invoice->no_invoice = $invoice->UNIQUE_KODE();
            $invoice->id_user = auth()->user()->id;
            $invoice->id_bank = $bank->id;
            $invoice->id_pemesanan = $pemesanan->id;
            $invoice->status = 1;
            $invoice->tgl_terbit = NOW();
            $invoice->save();
            session()->flash('message-success', "Data berhasil diubah!");
        }

        foreach ($pemesanan->PemesananDetail->where('status_barang_user',1)->where('status_ditambahkan',1) as $item) {
            $item->status_ditambahkan = 2;
            $item->tgl_harga_acc = NOW();
            $item->save();
        }
        session()->flash('message-success', "Data berhasil diubah!");
        
    }
    function pesananDiterima(){
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        $pemesanan->status = 8;
        if ($pemesanan->Invoice != null) {
            if ($pemesanan->Invoice->status == 3) {
                $pemesanan->status = 9;
            }
        }
        $pemesanan->tgl_selesai = NOW();
        $pemesanan->save();

        $pemesanan->setTimelinePemesanan($pemesanan->id);

        session()->flash('message-success', "Data berhasil diubah!");
    }
    public function render()
    {
        $pemesanan = Pemesanan::find($this->pemesanan->id);
        return view('livewire.pemesanan.proses',compact('pemesanan'));
    }
}
