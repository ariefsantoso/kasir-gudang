<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Barang';
        return view('admin.stok.index', [
            'title' => $title,
            'barang' => Barang::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Input Barang';
        return view('admin.stok.create', [
            'title' => $title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode.*' => 'required',
            'nama_barang.*' => 'required',
        ]);

        foreach ($request->input('kode') as $key => $kode) {
            $dataBarang = [
                'kode' => $kode,
                'name' => $request->input('nama_barang')[$key],
                'stok' => 0
            ];
            Barang::create($dataBarang);
        }
        // dd($dataBarang);
        return redirect('/barang')->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit($kode)
    {
        // $barangs = Barang::findOrFail($id);
        $barangs = Barang::where('kode', $kode)->first();
        // dd($barangs);
        $title = 'Edit Barang';
        return view('admin.stok.edit', [
            'title' => $title,
            'barang' => $barangs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        // dd($barang);
        $request->validate([
            'kode' => 'required',
            'nama_barang.*' => 'required',
            'harga.*' => 'required|numeric',
        ]);

        $barang->update([
            'kode' => $request->input('kode'),
            'name' => $request->input('nama_barang')
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        // dd($barang);
        $barang->delete();
        return redirect('/barang')->with('success', 'Data barang berhasil dihapus.');
    }
}
