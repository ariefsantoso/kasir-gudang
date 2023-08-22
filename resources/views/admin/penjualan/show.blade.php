@extends('layouts.main')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">{{ ($title) }}</h6>
             <h6 class="mb-0">Kode Transaksi : {{ ($transaksis->kode_transaksi) }}</h6>
            {{-- @if ($duplicate)
            <h6>
                Kode Barang : {{ ($duplicate->kode) }}
            </h6>
            @endif --}}
            
        </div>
        
        
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                        <th scope="col">Jenis Transaksi</th>
                        <th scope="col">Kode Transaksi</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Total Item</th>
                        <th scope="col">Harga</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $duplicate)
                    <tr>
                        {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                        <td>{{ ($duplicate->jenis_transaksi) }}</td>
                        <td>{{ ($duplicate->kode_transaksi) }}</td>                            
                        <td>{{ ($duplicate->barang->name) }}</td>                            
                        <td>{{ ($duplicate->jumlah) }}</td>
                        <td>{{ ($duplicate->harga) }}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr class="text-dark">
                        {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                        <th scope="col" colspan="3">Total</th>
                        {{-- <th scope="col"></th>
                        <th scope="col"></th> --}}
                        <th scope="col">{{ ($transaksi->sum('jumlah')) }}</th>
                        <th scope="col">{{ $transaksi->sum('harga') }}</th>
                        
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>
@endsection