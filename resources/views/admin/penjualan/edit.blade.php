
@extends('layouts.main')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0">{{ ($title) }}</h6>
        <h6 class="mb-0">{{ ($transaksis->kode_transaksi) }}</h6>
    </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="transaction-body">
                    @foreach ($transaksi as $duplicate)
                    <form method="post" action="/penjualan/{{ $duplicate->kode_transaksi }}">
                        @csrf
                        @method('PUT')
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="kode_transaksi" value="{{ $duplicate->kode_transaksi }}" readonly>
                        </td>
                        <td>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" name="barang_id" id="barang_id">
                                    {{-- <option value="{{ ($duplicate->barang_id) }}" disabled selected>{{ ($duplicate->barang->name) }}</option> --}}
                                    @foreach ($barangs as $item)                        
                                        <option value="{{ $item->id }}" {{ $item->id == $duplicate->barang_id ? 'selected' : ''}}>{{ ($item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="jumlah" value="{{ $duplicate->jumlah }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="harga" value="{{ $duplicate->harga }}">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </td>
                    </tr>
                    </form>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 mb-2">
            <button type="button" class="btn btn-primary" id="addTransaction">Tambah Transaksi</button>
            {{-- <button type="submit" class="btn btn-primary mb-2 mt-3" id="submitTransactions">Simpan</button> --}}
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#addTransaction').on('click', function() {
        const newRow = `
        <tr>
            
                <td><input type="text" class="form-control" name="kode_transaksi" value="{{ ($transaksis->kode_transaksi) }}" readonly></td>
                <td>
                    <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" name="barang_id" id="barang_id">
                                    @foreach ($barangs as $item)                        
                                        <option value="{{ $item->id }}">{{ ($item->name) }}</option>
                                    @endforeach
                                </select>
                    </div>
                </td>
                <td><input type="text" class="form-control" name="jumlah" value=""></td>
                <td><input type="text" class="form-control" name="harga" value=""></td>
                <td><button type="submit" class="btn btn-primary">Update</button></td>
            
        </tr>
        `;
        $('#transaction-body').append(newRow);
    });
    
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });
    
    $('#submitTransactions').on('click', function() {
        $('form').submit();
    });
});
</script>

@endsection
