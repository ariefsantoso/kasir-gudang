@extends('layouts.main')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0">{{ ($title) }}</h6>
        
    </div>

    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf
        <div id="form-container">
            <!-- Form pertama -->
            <div class="form-group">
                <label for="kode_1" class="mb-2">Kode Barang</label>
                <input type="text" class="form-control kode-input" id="kode_transaksi_1" name="kode_transaksi[]">
            </div>
            <br>
            <div class="mb-3 row">
                <label for="barang_id" class="col-sm-2 col-form-label">Nama Barang</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" name="barang_id[]" id="barang_id_1">
                        <option value="" disabled selected>Pilih Nama Barang</option>
                        @foreach ($barang as $item)                        
                            <option value="{{ ($item->id) }}">{{ ($item->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="jumlah[]" id="jumlah_1" placeholder="Masukkan Jumlah">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" name="harga[]" id="harga_1" placeholder="Masukkan Harga">
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="col-auto">
            <button type="button" onclick="addForm()" class="btn btn-primary mb-3">Tambah Form Barang</button>
            {{-- <button type="submit" class="btn btn-primary mb-3">Insert Barang</button> --}}
            <div class="mb-3">
                <input type="submit" value="Simpan" class="btn btn-primary mb-3">
            </div>
        </div>
        <br>
        {{-- <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Insert Barang</button>
        </div>   --}}
    </form>
    <br>
</div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                generateKodeOtomatis(1); // Memanggil fungsi untuk mengisi kode transaksi pada form pertama
            });
            let formCounter = 1;

            function addForm() {
                formCounter++;

                const formContainer = document.getElementById('form-container');
                const newForm = document.createElement('div');
                newForm.innerHTML = `
                <br>
                <hr>
                <br>
                <div class="mb-3">
                        <label for="kode_${formCounter}" class="form-label">Kode</label>
                        <input type="text" class="form-control" name="kode_transaksi[]" id="kode_transaksi_${formCounter}" placeholder="Kode Transaksi" readonly>
                    </div>
            
                    <div class="mb-3 row">
                        <label for="barang_id" class="col-sm-2 col-form-label">Nama Barang</label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" name="barang_id[]" id="barang_id_${formCounter}">
                                    <option value="" disabled selected>Pilih Nama Barang</option>
                                    @foreach ($barang as $item)                        
                                        <option value="{{ ($item->id) }}">{{ ($item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="mb-3 row">
                <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="jumlah[]" id="jumlah_${formCounter}" placeholder="Masukkan Jumlah">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="harga[]" id="harga_${formCounter}" placeholder="Masukkan Harga">
                    </div>
                </div>
                <button type="button" onclick="removeForm(this)" class="btn btn-danger mb-3">Hapus Form</button>
                `;
                formContainer.appendChild(newForm);
                generateKodeOtomatis(formCounter);
            }
            function removeForm(button) {
                const formContainer = document.getElementById('form-container');
                formContainer.removeChild(button.parentNode);
            }

            function generateKodeOtomatis(formNumber) {
                $.ajax({
                    url: '/get_last_kode_pembelian', // Ubah sesuai dengan URL endpoint Anda
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let lastKode = response.data.kode_transaksi;
                            let currentNumber = parseInt(lastKode.substr(12));
                            let nextNumber = currentNumber + 1;
                            var today = new Date();
                            var year = today.getFullYear().toString().substr(-2);
                            var month = ("0" + (today.getMonth()+1)).slice(-2);
                            var day = ("0" + today.getDate()).slice(-2)
                            let nextKode = 'TRANSB' + day + month + year + nextNumber.toString().padStart(3, '0');
                            $('#kode_transaksi_1').val(nextKode);
                            $('#kode_transaksi_' + formNumber).val(nextKode);

                            // for (let i = 0; i < kodeInputs.length; i++) {
                            //     let formNumber = i + 0;
                            //     let nextNumber = currentNumber + formNumber;
                            //     let nextKode = 'BRG' + nextNumber.toString().padStart(3, '0');
                            //     kodeInputs[i].value = nextKode;
                            // }

                            // $('#kode_transaksi').val(nextKode);
                            // document.getElementById(`kode_transaksi_${formNumber}`).value = nextKode;
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        </script>
    


@endsection