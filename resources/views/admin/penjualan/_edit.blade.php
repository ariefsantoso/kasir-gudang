@extends('layouts.main')
@section('content')
<div class="container-fluid pt-4 px-4">
    

    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">{{ ($title) }}</h6>
            <h6 class="mb-0">{{ ($transaksis->kode_transaksi) }}</h6>
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
                    <?php 
                        $no = 1;
                    ?>
                    @foreach ($transaksi as $duplicate)
                    <tr>
                        <form method="post" action="/penjualan/{{ $duplicate->kode_transaksi }}">
                            @csrf
                            @method('PUT')
                        {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                        <td>{{ ($duplicate->jenis_transaksi) }}</td>
                        {{-- <td>{{ ($duplicate->kode_transaksi) }}</td> --}}
                        <td><input type="text" class="form-control" name="kode_transaksi[]" id="kode_transaksi_{{ $no }}" placeholder="Masukkan Jumlah" value="{{ ($duplicate->kode_transaksi) }}" readonly></td>                            
                        <td>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" name="barang_id[]" id="barang_id_{{ $no }}">
                                    {{-- <option value="{{ ($duplicate->barang_id) }}" disabled selected>{{ ($duplicate->barang->name) }}</option> --}}
                                    @foreach ($barangs as $item)                        
                                        <option value="{{ $item->id }}" {{ $item->id == $duplicate->barang_id ? 'selected' : ''}}>{{ ($item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>                            
                        <td><input type="text" class="form-control" name="jumlah[]" id="jumlah_{{ $no }}" placeholder="Masukkan Jumlah" value="{{ ($duplicate->jumlah) }}"></td>
                        <td><input type="text" class="form-control" name="harga[]" id="harga_{{ $no }}" placeholder="Masukkan Harga" value="{{ ($duplicate->harga) }}"></td>
                        
                       
                        
                    </tr>
                    <?php
                    $no++; 
                    ?>
                    @endforeach
                </tbody>

            </table>
        </div>
        <div class="mt-3 mb-2">
            <button type="submit" class="btn btn-primary mb-2 mt-3">Simpan</button>
        </div>
    </div>
</form>
</div>
@endsection

{{-- @extends('layouts.main')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="transaction-body">
                    @foreach ($transaksi as $duplicate)
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="kode_transaksi[]" value="{{ $duplicate->kode_transaksi }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="jumlah[]" value="{{ $duplicate->jumlah }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="harga[]" value="{{ $duplicate->harga }}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-row">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 mb-2">
            <button type="button" class="btn btn-primary" id="addTransaction">Tambah Transaksi</button>
            <button type="submit" class="btn btn-primary mb-2 mt-3" id="submitTransactions">Simpan</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#addTransaction').on('click', function() {
        const newRow = `
            <tr>
                <td><input type="text" class="form-control" name="kode_transaksi[]" value=""></td>
                <td><input type="text" class="form-control" name="jumlah[]" value=""></td>
                <td><input type="text" class="form-control" name="harga[]" value=""></td>
                <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
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
@endsection --}}
