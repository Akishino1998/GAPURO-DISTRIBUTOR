<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKategori;
use App\Models\BarangMerk;
use App\Models\BarangSatuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;

class BarangController extends Controller
{
    function index(){
        return view('barang.index');
    }
    function create(){
        $merk = BarangMerk::get();
        $kategori = BarangKategori::get();
        $satuan = BarangSatuan::get();
        return view('barang.create',compact('kategori','merk','satuan'));
    }
    public function store(Request $request)
    {
        $merk = BarangMerk::where('id','LIKE',$request->id_merk)->get();
        if (COUNT($merk)==0) {
            $merk = BarangMerk::where('merk','LIKE',$request->id_merk)->get();
            if (COUNT($merk)==0) {
                $merk = new BarangMerk;
                $merk->merk = $request->id_merk;
                $merk->save();
                $request->merge(['id_merk' => $merk->id]);
            }else{
                $request->merge(['id_merk' => $merk->first()->id]);
            }
        }
        $kategori = BarangKategori::where('id','LIKE',$request->id_kategori)->get();
        if (COUNT($kategori)==0) {
            $kategori = BarangKategori::where('kategori','LIKE',$request->id_kategori)->get();
            if (COUNT($kategori)==0) {
                $kategori = new BarangKategori;
                $kategori->kategori = $request->id_kategori;
                $kategori->save();
                $request->merge(['id_kategori' => $kategori->id]);
            }else{
                $request->merge(['id_kategori' => $kategori->first()->id]);
            }
        }

        $satuan = BarangSatuan::where('id','LIKE',$request->id_satuan)->get();
        if (COUNT($satuan)==0) {
            $satuan = BarangSatuan::where('kategori','LIKE',$request->id_satuan)->get();
            if (COUNT($satuan)==0) {
                $satuan = new BarangSatuan;
                $satuan->satuan = $request->id_satuan;
                $satuan->save();
                $satuan->merge(['id_satuan' => $satuan->id]);
            }else{
                $request->merge(['id_satuan' => $satuan->first()->id]);
            }
        }

        $barang = new Barang;
        $barang->id_admin = Auth::user()->id;
        $barang->id_kategori = $request->id_kategori;
        $barang->id_satuan = $request->id_satuan;
        $barang->id_merk = $request->id_merk;                
        $barang->nama_barang = $request->nama_barang;
        $barang->alt_barang = $merk->first()->merk."".$kategori->first()->kategori." " .$request->nama_barang;
        $barang->deskripsi = $request->deskripsi;
        $barang->harga_jual = str_replace(".","",$request->harga_jual);
        $barang->save();
        if (isset($request->galeri)) {
            $image = $request->galeri;
            $extension = $image->extension();
            $lokasi = 'storage/thumbnail/thumbnail-sparepart-'.time().'.'.$extension;
        
            $image = Image::make($request->file('galeri')->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($lokasi);

            $extension = $request->file('galeri')->getClientOriginalExtension();
            $filenameSimpan = 'barang-'.time().'.'.$extension;
            $path = $request->file('galeri')->storeAs('public/foto-barang/', $filenameSimpan);
            $barang->foto = "foto-barang/".$filenameSimpan;
            $barang->save();

            $barang->foto_thumbnail = 'thumbnail/thumbnail-sparepart-'.time().'.'.$extension;
            $barang->save();
        }
        Flash::success('Data sparepart berhasil ditambahkan.');

        return redirect(route('barang.index'));
    }
    public function show($id)
    {
        $barang = Barang::find($id);
        if (empty($barang)) {
            Flash::error('Tidak ditemukan');
            return redirect(route('barang.index'));
        }
        return view('barang.show')->with('barang', $barang);
    }
    public function edit($id)
    {
        $barang = Barang::find($id);
        if (empty($barang)) {
            Flash::error('Tidak ditemukan');
            return redirect(route('sparepart.index'));
        }
        $merk = BarangMerk::get();
        $satuan = BarangSatuan::get();
        $kategori = BarangKategori::get();
        return view('barang.edit',compact('merk','kategori','satuan'))->with('barang', $barang);
    }
    public function update($id, Request $request)
    {
        $barang = Barang::find($id);
        if (empty($barang)) {
            Flash::error('Tidak ditemukan');
            return redirect(route('barang.index'));
        }
        $merk = BarangMerk::where('id','LIKE',$request->id_merk)->get();
        if (COUNT($merk)==0) {
            $merk = BarangMerk::where('merk','LIKE',$request->id_merk)->get();
            if (COUNT($merk)==0) {
                $merk = new BarangMerk;
                $merk->merk = $request->id_merk;
                $merk->save();
                $request->merge(['id_merk' => $merk->id]);
            }else{
                $request->merge(['id_merk' => $merk->first()->id]);
            }
        }
        $kategori = BarangKategori::where('id','LIKE',$request->id_kategori)->get();
        if (COUNT($kategori)==0) {
            $kategori = BarangKategori::where('kategori','LIKE',$request->id_kategori)->get();
            if (COUNT($kategori)==0) {
                $kategori = new BarangKategori;
                $kategori->kategori = $request->id_kategori;
                $kategori->save();
                $request->merge(['id_kategori' => $kategori->id]);
            }else{
                $request->merge(['id_kategori' => $kategori->first()->id]);
            }
        }
        
        $satuan = BarangSatuan::where('id','LIKE',$request->id_satuan)->get();
        if (COUNT($satuan)==0) {
            $satuan = BarangSatuan::where('kategori','LIKE',$request->id_satuan)->get();
            if (COUNT($satuan)==0) {
                $satuan = new BarangSatuan;
                $satuan->satuan = $request->id_satuan;
                $satuan->save();
                $satuan->merge(['id_satuan' => $satuan->id]);
            }else{
                $request->merge(['id_satuan' => $satuan->first()->id]);
            }
        }

        $barang = Barang::find($id);
        $barang->id_kategori = $request->id_kategori;
        $barang->id_merk = $request->id_merk;                
        $barang->id_satuan = $request->id_satuan;                
        $barang->nama_barang = $request->nama_barang;
        $barang->alt_barang = $merk->first()->merk."".$kategori->first()->kategori." " .$request->nama_barang;
        $barang->deskripsi = $request->deskripsi;
        $barang->harga_jual = str_replace(".","",$request->harga_jual);
        if (isset($request->galeri)) {
            $image = $request->galeri;
            $extension = $image->extension();
            $lokasi = 'storage/thumbnail/thumbnail-sparepart-'.time().'.'.$extension;
        
            $image = Image::make($request->file('galeri')->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($lokasi);

            $extension = $request->file('galeri')->getClientOriginalExtension();
            $filenameSimpan = 'barang-'.time().'.'.$extension;
            $path = $request->file('galeri')->storeAs('public/foto-barang/', $filenameSimpan);
            $barang->foto = "foto-barang/".$filenameSimpan;
            $barang->save();

            $barang->foto_thumbnail = 'thumbnail/thumbnail-sparepart-'.time().'.'.$extension;
            $barang->save();
        }
        $barang->save();
        Flash::success('Data sparepart berhasil diubah.');
        return redirect(route('barang.index'));
    }
    public function destroy($id)
    {
        $barang = Barang::find($id);
        if (empty($barang)) {
            Flash::error('Tidak ditemukan');
            return redirect(route('barang.index'));
        }
        $barang->delete();
        Flash::success('Data sparepart berhasil dihapus.');
        return redirect(route('barang.index'));
    }
}
