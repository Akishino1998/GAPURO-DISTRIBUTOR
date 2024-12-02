<?php

use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect(route('dashboard'));
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
                Route::get('/set-harga/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'setHarga'])->name('setHarga');
                Route::get('/penerimaan/{id}', [App\Http\Controllers\Admin\PemesananController::class, 'penerimaan'])->name('penerimaan');
            });

            Route::resource('pemesanan', App\Http\Controllers\Admin\PemesananController::class);
        });
        Route::resource('barang', App\Http\Controllers\BarangController::class);
        Route::resource('toko', App\Http\Controllers\TokoController::class);
        Route::get('/konsumen/{id}/harga', [App\Http\Controllers\KonsumenController::class, 'harga'])->name('konsumen.harga');
        Route::get('/konsumen/{id}/set-harga', [App\Http\Controllers\KonsumenController::class, 'setHarga'])->name('konsumen.setHarga');
        Route::resource('konsumen', App\Http\Controllers\KonsumenController::class);

        Route::group(['prefix'=>'pemesanan','as'=>'pemesanan.' ],function () {
            Route::get('/cek-harga/{id}', [App\Http\Controllers\PemesananController::class, 'cekHarga'])->name('cekHarga');
        });
        Route::resource('pemesanan', App\Http\Controllers\PemesananController::class);


    });
// });





