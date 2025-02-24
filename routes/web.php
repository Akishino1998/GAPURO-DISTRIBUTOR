<?php

use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('profil.index');
});

// Route::group(['middleware'=>['Log'] ],function () {
    Route::group(['middleware'=>['auth','RolePermission'] ],function () {
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
        Route::group(['prefix'=>'admin','as'=>'admin.' ],function () {
            Route::group(['prefix'=>'master','as'=>'master.' ],function () {
                Route::group(['prefix'=>'user','as'=>'user.' ],function () {
                    Route::get('/', [App\Http\Controllers\PenggunaController::class, 'index'])->name('index');
                    Route::get('/create', [App\Http\Controllers\PenggunaController::class, 'create'])->name('create');
                    Route::POST('/store', [App\Http\Controllers\PenggunaController::class, 'store'])->name('store');
                    Route::DELETE('/destroy/{id}', [App\Http\Controllers\PenggunaController::class, 'destroy'])->name('destroy');
                });
                Route::resource('merk', App\Http\Controllers\BarangMerkController::class);
                Route::resource('kategori', App\Http\Controllers\BarangKategoriController::class);
                Route::resource('satuan', App\Http\Controllers\BarangSatuanController::class);
            });
            Route::group(['prefix'=>'pemesanan','as'=>'pemesanan.' ],function () {
                Route::get('/request/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'request'])->name('request');
                Route::get('/set-harga/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'setHarga'])->name('setHarga');
                Route::get('/penerimaan/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'penerimaan'])->name('penerimaan');
                Route::get('/menyiapkan/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'menyiapkan'])->name('menyiapkan');
                Route::get('/menyiapkan/{id}/print', [App\Http\Controllers\Admin\PemesananController::class, 'menyiapkanPrint'])->name('menyiapkanPrint');
                Route::get('/invoice/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'invoice'])->name('invoice');
                Route::post('/invoice/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'invoiceSimpan'])->name('invoiceSimpan');
                Route::post('/invoice/{id}/bayar', [App\Http\Controllers\Admin\PemesananController::class, 'invoiceBayar'])->name('invoiceBayar');
                Route::get('/invoice/{id}/print', [App\Http\Controllers\Admin\PemesananController::class, 'invoicePrint'])->name('invoicePrint');
                Route::get('/invoice/{id}/terbit', [App\Http\Controllers\Admin\PemesananController::class, 'invoiceTerbit'])->name('invoiceTerbit');
                Route::get('/invoice/{id}/download', [App\Http\Controllers\Admin\PemesananController::class, 'invoiceDownload'])->name('invoiceDownload');
            });
            Route::group(['prefix'=>'laporan','as'=>'laporan.' ],function () {
                Route::get('/invoice', [App\Http\Controllers\LaporanController::class, 'invoice'])->name('invoice');
                Route::get('/pendapatan', [App\Http\Controllers\LaporanController::class, 'pendapatan'])->name('pendapatan');
            });

            Route::resource('pemesanan', App\Http\Controllers\Admin\PemesananController::class);
            Route::resource('invoice', App\Http\Controllers\Admin\InvoiceController::class);
        });
        Route::resource('barang', App\Http\Controllers\BarangController::class);
        Route::resource('toko', App\Http\Controllers\TokoController::class);
        Route::get('/konsumen/{id}/harga', [App\Http\Controllers\KonsumenController::class, 'harga'])->name('konsumen.harga');
        Route::get('/konsumen/{id}/set-harga', [App\Http\Controllers\KonsumenController::class, 'setHarga'])->name('konsumen.setHarga');
        Route::resource('konsumen', App\Http\Controllers\KonsumenController::class);

        Route::group(['prefix'=>'pemesanan','as'=>'pemesanan.' ],function () {
            Route::get('/verifikasi/{id}', [App\Http\Controllers\PemesananController::class, 'verifikasi'])->name('verifikasi');
            Route::get('/cek-harga/{id}', [App\Http\Controllers\PemesananController::class, 'cekHarga'])->name('cekHarga');
        });
        Route::get('/pemesanan/{id}/invoice', [App\Http\Controllers\PemesananController::class, 'invoicePemesanan'])->name('invoicePemesanan');
        Route::get('/pemesanan/{id}/tambah', [App\Http\Controllers\PemesananController::class, 'tambahPemesanan'])->name('tambahPemesanan');
        Route::resource('pemesanan', App\Http\Controllers\PemesananController::class);
    });
// });





