<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $title = 'Dashboard';
        $month = now()->format('m');
        $kode_transaksi = 'J';
        // $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->get();
        $transaksi = Transaksi::get();
        return view('admin.index', [
            'title' => $title,
            'transaksi' => $transaksi
        ]);
    }

    public function calculateStock()
    {
        $transactions = Transaksi::all();
        $products = Barang::all();

        $stock = [];

        foreach ($products as $product) {
            $product->stok = 0;
            $product->save();
        }

        foreach ($products as $product) {
            $stock[$product->id] = $product->stok;
        }

        // Hitung Transaksi Beli 
        foreach ($transactions as $transaction) {
            if ($transaction->jenis_transaksi === 'B') {
                $stock[$transaction->barang_id] += $transaction->jumlah;
            }
        }

        // Hitung Transaksi Jual 
        foreach ($transactions as $transaction) {
            if ($transaction->jenis_transaksi === 'J') {
                $stock[$transaction->barang_id] -= $transaction->jumlah;
            }
        }

        //Insert To Stok
        foreach ($stock as $product_id => $product_stock) {
            $product = Barang::find($product_id);
            $product->stok = $product_stock;
            // dd($product);
            $product->save();
        }
        return Redirect::back()->with('message', 'Perhitungan stok selesai dan nilai stok telah diperbarui.');

        // return $stock;
    }
}
