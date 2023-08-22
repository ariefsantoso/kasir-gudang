@extends('layouts.main')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">{{ ($title) }}</h6>
            <a href="/stok" class="btn btn-danger">Hitung Ulang Stok</a>
            
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                        <th scope="col">Kode</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $barang)
                    <tr>
                        {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                        <td>{{ ($barang->kode) }}</td>
                        <td>{{ ($barang->name) }}</td>
                        <td>{{ ($barang->stok) }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="">Detail</a>
                            <a class="btn btn-sm btn-warning" href="/barang/{{ $barang->kode }}/edit">Edit</a>
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="post" class="d-inline">
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
    </div>
</div>
@endsection