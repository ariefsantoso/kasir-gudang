<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;


class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $keywoard = $request->keywoard;
        $title = 'Transaksi Penjualan';

        $duplicate = Transaksi::select('kode_transaksi', 'jenis_transaksi', 'created_at', Transaksi::raw('SUM(harga) as total_harga'), Transaksi::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('kode_transaksi', 'jenis_transaksi', 'harga', 'created_at')
            ->havingRaw('COUNT(kode_transaksi) >= 1')
            ->where('jenis_transaksi', 'J')->where('kode_transaksi', 'LIKE', '%' . $keywoard . '%');
        if (!empty($start_date) && !empty($end_date)) {
            $duplicate->whereBetween('created_at', [$start_date, $end_date]);
        }

        $duplicate = $duplicate->paginate(10)->withQueryString();
        // $tanggal = Transaksi::select('created_at')->groupBy('created_at')->havingRaw('count')

        return view('admin.penjualan.index', [
            'title' => $title,
            // 'penjualan' => Transaksi::where('jenis_transaksi', 'J')->get(),
            // "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString(),
            'duplicates' => $duplicate

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Input Penjualan';
        return view('admin.penjualan.create', [
            'title' => $title,
            'barang' => Barang::all()
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
            'kode_transaksi' => 'required',
            'barang_id.*' => 'required',
            'jumlah.*' => 'required',
            'harga.*' => 'required'
        ]);
        // dd($request);

        foreach ($request->input('kode_transaksi') as $key => $kode) {
            $dataBarang = [
                'kode_transaksi' => $kode,
                'barang_id' => $request->input('barang_id')[$key],
                'jumlah' => $request->input('jumlah')[$key],
                'harga' => $request->input('harga')[$key],
                'jenis_transaksi' => 'J'
            ];
            Transaksi::create($dataBarang);
        }
        // Set data lain yang perlu disimpan sesuai kebutuhan



        return redirect('/penjualan')->with('success', 'Transaksi Penjualan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show($kode_transaksi)
    {
        $title = 'Detail Transaksi Penjualan';
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->get();
        $transaksi2 = Transaksi::where('kode_transaksi', $kode_transaksi)->first();
        return view('admin.penjualan.show', [
            'title' => $title,
            'transaksi' => $transaksi,
            'transaksis' => $transaksi2
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit($kode_transaksi)
    {
        $title = 'Edit Penjualan';
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->get();
        $transaksi2 = Transaksi::where('kode_transaksi', $kode_transaksi)->first();
        return view('admin.penjualan.edit', [
            'title' => $title,
            'transaksi' => $transaksi,
            'transaksis' => $transaksi2,
            'barangs' => Barang::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode_transaksi)
    {
        // dd($request->all());

        $request->validate([
            'barang_id.*' => 'required',
            'jumlah.*' => 'required',
            'harga.*' => 'required'
        ]);

        // dd($kode_transaksi);
        // dd($kode_transaksi);
        for ($i = 0; $i < count($request->kode_transaksi); $i++) {
            Transaksi::where('kode_transaksi', $request->kode_transaksi[$i])->update([
                // $data[$request->kode_transaksi[$i]][] = [
                'barang_id' => $request->barang_id[$i],
                'jumlah' => $request->jumlah[$i],
                'harga' => $request->harga[$i]
            ]);
        }

        // return redirect('/penjualan')->with('success', 'Transaksi Penjualan berhasil diedit.');
        return Redirect::back()->with('success', 'Transaksi Penjualan berhasil diedit.');
        // dd(count($request->kode_transaksi));

        // Transaksi::where('kode_transaksi', $data)->update($data);



        // dd($data);
        // foreach ($data as $kodeTransaksi => $items) {
        //     foreach ($items as $item) {

        // Transaksi::updateOrCreate(
        //     [
        //         'kode_transaksi' => $kodeTransaksi,
        //         'jenis_transaksi' => $item['jenis_transaksi'],
        //         'barang_id' => $item['barang_id'],
        //         'jumlah' => $item['jumlah'],
        //         'harga' => $item['harga']
        //     ]
        // );
        //         Transaksi::where('kode_transaksi', $kodeTransaksi)
        //             ->where('barang_id', $item['barang_id'])
        //             ->update([
        //                 'jumlah' => $item['jumlah'],
        //                 'harga' => $item['harga']
        //             ]);
        //     }
        // }


    }

    public function coba(Request $request, $kode_transaksi)
    {
        $transaksi = Transaksi::findOrFail($kode_transaksi);
        dd($transaksi);
        $request->validate([
            'barang_id' => 'required',
            'jumlah' => 'required',
            'harga' => 'required'
        ]);

        $transaksi->updateOrCreate([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga
        ]);

        return Redirect::back()->with('success', 'Transaksi Penjualan berhasil diedit.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_transaksi)
    {

        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi);
        $transaksi->delete();
        // Transaksi::where('kode_transaksi', $kode_transaksi)->delete();

        return redirect('/penjualan')->with('success', 'Data barang berhasil dihapus.');
    }

    public function penjualanpdf($kode_transaksi)
    {
        $title = 'Detail Transaksi Penjualan';
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->get();
        $transaksi2 = Transaksi::where('kode_transaksi', $kode_transaksi)->first();

        $pdf = PDF::loadView('admin.penjualan.pdf', [
            'title' => $title,
            'transaksi' => $transaksi,
            'transaksis' => $transaksi2
        ]);
        // return $pdf->download('contoh.pdf');
        return $pdf->stream($kode_transaksi . '.pdf');
    }

    public function index_pembelian(Request $request)
    {
        $keywoard = $request->keywoard;
        // dd($keywoard);
        $title = 'Transaksi Pembelian';
        $duplicate = Transaksi::select('kode_transaksi', 'jenis_transaksi', 'created_at', Transaksi::raw('SUM(harga) as total_harga'), Transaksi::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('kode_transaksi', 'jenis_transaksi', 'harga', 'created_at')
            ->havingRaw('COUNT(kode_transaksi) >= 1')
            ->where('jenis_transaksi', 'B')->where('kode_transaksi', 'LIKE', '%' . $keywoard . '%');

        if (!empty($start_date) && !empty($end_date)) {
            $duplicate->whereBetween('created_at', [$start_date, $end_date]);
        }
        $duplicate = $duplicate->paginate(10)->withQueryString();


        return view('admin.pembelian.index', [
            'title' => $title,
            // 'pembelian' => Transaksi::where('jenis_transaksi', 'B')->get(),
            'duplicates' => $duplicate,
            'keywoard' => $keywoard

        ]);
    }

    public function create_pembelian()
    {
        $title = 'Input Pembelian';
        return view('admin.pembelian.create', [
            'title' => $title,
            'barang' => Barang::all()
        ]);
    }

    public function store_pembelian(Request $request)
    {
        $request->validate([
            'kode_transaksi' => 'required',
            'barang_id.*' => 'required',
            'jumlah.*' => 'required',
            'harga.*' => 'required'
        ]);
        // dd($request);

        foreach ($request->input('kode_transaksi') as $key => $kode) {
            $dataBarang = [
                'kode_transaksi' => $kode,
                'barang_id' => $request->input('barang_id')[$key],
                'jumlah' => $request->input('jumlah')[$key],
                'harga' => $request->input('harga')[$key],
                'jenis_transaksi' => 'B'
            ];
            Transaksi::create($dataBarang);
        }
        // Set data lain yang perlu disimpan sesuai kebutuhan

        $this->tambahstok();

        return redirect('/pembelian')->with('success', 'Transaksi Pembelian berhasil ditambahkan.');
    }

    public function showpembelian($kode_transaksi)
    {
        $title = 'Detail Transaksi Pembelian';
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->get();
        $transaksi2 = Transaksi::where('kode_transaksi', $kode_transaksi)->first();
        return view('admin.penjualan.show', [
            'title' => $title,
            'transaksi' => $transaksi,
            'transaksis' => $transaksi2
        ]);
    }

    public function editpembelian($kode_transaksi)
    {
        $title = 'Edit Pembelian';
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->get();
        $transaksi2 = Transaksi::where('kode_transaksi', $kode_transaksi)->first();
        return view('admin.penjualan.edit', [
            'title' => $title,
            'transaksi' => $transaksi,
            'transaksis' => $transaksi2,
            'barangs' => Barang::all()
        ]);
    }


    public function pembelianpdf(Request $request, $kode_transaksi)
    {
        $title = 'Detail Transaksi Pembelian';
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->get();
        $transaksi2 = Transaksi::where('kode_transaksi', $kode_transaksi)->first();

        $pdf = PDF::loadView('admin.pembelian.pdf', [
            'title' => $title,
            'transaksi' => $transaksi,
            'transaksis' => $transaksi2
        ]);
        // return $pdf->download('contoh.pdf');
        return $pdf->stream($kode_transaksi . '.pdf');
    }

    public function tambahstok()
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

        foreach ($stock as $product_id => $product_stock) {
            $product = Barang::find($product_id);
            $product->stok = $product_stock;
            // dd($product);
            $product->save();
        }
    }
}
