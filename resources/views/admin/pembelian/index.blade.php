@extends('layouts.main')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">{{ ($title) }}</h6>
                {{-- <div class="my-3 col-12 col-sm-8 col-md-5"> --}}
                    <a href="/pembelian/create" class="btn btn-primary">Tambah Data </a>
                    <form action="" method="get">                    
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" name="start_date" id="start_date">
                            <input type="date" class="form-control" name="end_date" id="end_date">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="floatingInputGroup1" placeholder="Input Kode Transaksi" name="keywoard" value="{{ request('search') }}">
                            <button type="submit" class="input-group-text btn btn-primary">Search</button>
                        </div>
                    </form>
                {{-- </div> --}}
            
        </div>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        @if ($duplicates->count() > 0)
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                        <th scope="col">Tanggal Transaksi</th>
                        <th scope="col">Jenis Transaksi</th>
                        <th scope="col">Kode Transaksi</th>
                        {{-- <th scope="col">Total Items</th> --}}
                        {{-- <th scope="col">Harga</th> --}}
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($duplicates as $duplicate)
                    <tr>
                        {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                        <td>{{ ($duplicate->created_at->format('d/m/Y')) }}</td>
                        <td>{{ ($duplicate->jenis_transaksi) }}</td>
                        <td><a href="/pembelian/{{ $duplicate->kode_transaksi }}">{{ ($duplicate->kode_transaksi) }}</a></td>                            
                        {{-- <td>{{ ($duplicate->total_jumlah) }}</td> --}}
                        {{-- <td>{{ ($duplicate->total_harga) }}</td> --}}
                        <td>
                            {{-- <a class="btn btn-sm btn-primary" href="">Detail</a> --}}
                            <a class="btn btn-sm btn-primary" href="/print/{{ $duplicate->kode_transaksi }}" target="_blank">Print</a>
                            <a class="btn btn-sm btn-warning" href="/pembelian/{{ $duplicate->kode_transaksi }}/edit">Edit</a>
                            <form action="{{ route('transaksi.destroy', $duplicate->kode_transaksi) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
         Tidak ada data
        @endif

        <div class=" my-5 d-flex justify-content-center">
            {{ $duplicates->links()}}
        </div>

    </div>
</div>
@endsection