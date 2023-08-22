<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LoginController;

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/stok', [DashboardController::class, 'calculateStock'])->middleware('auth');

Route::get('/barang', [BarangController::class, 'index'])->middleware('auth');
Route::get('/barang/create', [BarangController::class, 'create'])->middleware('auth');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store')->middleware('auth');
Route::get('/barang/{kode}/edit', [BarangController::class, 'edit'])->middleware('auth');
Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update')->middleware('auth');
Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy')->middleware('auth');
Route::get('/get_last_kode_barang', function (Request $request) {
    $lastBarang = Barang::latest('kode')->first();
    if ($lastBarang) {
        return response()->json(['success' => true, 'data' => $lastBarang]);
    } else {
        return response()->json(['success' => false]);
    }
});



Route::get('/penjualan', [TransaksiController::class, 'index'])->middleware('auth');
Route::get('/penjualan/create', [TransaksiController::class, 'create'])->middleware('auth');
Route::post('/penjualan', [TransaksiController::class, 'store'])->name('penjualan.store')->middleware('auth');
Route::get('/penjualan/{id}/edit', [TransaksiController::class, 'edit'])->middleware('auth');
Route::put('/penjualan/{id}', [TransaksiController::class, 'coba'])->name('penjualan.update')->middleware('auth');
Route::get('/penjualan/{id}', [TransaksiController::class, 'show'])->middleware('auth');
Route::delete('/penjualan/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy')->middleware('auth');
Route::get('/print/{id}',  [TransaksiController::class, 'penjualanpdf'])->middleware('auth');
Route::get('/get_last_kode_penjualan', function (Request $request) {
    $lastTransaksi  = Transaksi::orderBy('id', 'desc')->where('jenis_transaksi', 'J')->first();
    $lastTransaksi->kode_transaksi;
    if ($lastTransaksi) {
        return response()->json(['success' => true, 'data' => $lastTransaksi]);
    } else {
        return response()->json(['success' => false]);
    }
});

Route::get('/pembelian', [TransaksiController::class, 'index_pembelian'])->middleware('auth');
Route::get('/pembelian/create', [TransaksiController::class, 'create_pembelian'])->middleware('auth');
Route::post('/pembelian', [TransaksiController::class, 'store_pembelian'])->name('pembelian.store')->middleware('auth');
Route::get('/pembelian/{id}/edit', [TransaksiController::class, 'editpembelian'])->middleware('auth');
Route::get('/pembelian/{id}', [TransaksiController::class, 'showpembelian'])->middleware('auth');
Route::get('/print/{id}',  [TransaksiController::class, 'pembelianpdf'])->middleware('auth');
Route::get('/get_last_kode_pembelian', function () {
    $lastTransaksi  = Transaksi::orderBy('id', 'desc')->where('jenis_transaksi', 'B')->first();
    $lastTransaksi->kode_transaksi;
    if ($lastTransaksi) {
        return response()->json(['success' => true, 'data' => $lastTransaksi]);
    } else {
        return response()->json(['success' => false]);
    }
});

Route::get('/user', function () {
    return view('admin.user');
});
