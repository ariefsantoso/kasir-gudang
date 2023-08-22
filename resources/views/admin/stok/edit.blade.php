@extends('layouts.main')

@section('content')
<div class="container-fluid pt-4 px-4">

    <form action="{{ route('barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div id="form-container">
            <!-- Form pertama -->
            <div class="form-group">
                <label for="kode_1" class="mb-2">Kode Barang</label>
                <input type="text" class="form-control kode-input" name="kode" value="{{ $barang->kode }}" readonly>
            </div>
            <br>
            <div class="mb-3 row">
                <label for="nama_1" class="col-sm-2 col-form-label">Nama Barang</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="nama_barang" placeholder="Nama Barang" value="{{ $barang->name }}" autofocus>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="col-auto">
            {{-- <button type="button" onclick="addForm()" class="btn btn-primary mb-3">Tambah Form Barang</button> --}}
            {{-- <button type="submit" class="btn btn-primary mb-3">Insert Barang</button> --}}
            <div class="mb-3">
                <input type="submit" value="Simpan" class="btn btn-primary mb-3">
            </div>
        </div>
        <br>
    </form>
    <br>
</div>


@endsection