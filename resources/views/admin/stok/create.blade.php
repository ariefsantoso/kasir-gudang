@extends('layouts.main')

@section('content')
<div class="container-fluid pt-4 px-4">

    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div id="form-container">
            <!-- Form pertama -->
            <div class="form-group">
                <label for="kode_1" class="mb-2">Kode Barang</label>
                <input type="text" class="form-control kode-input" id="kode_1" name="kode[]">
            </div>
            <br>
            <div class="mb-3 row">
                <label for="nama_1" class="col-sm-2 col-form-label">Nama Barang</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="nama_barang[]" id="nama_1" placeholder="Nama Barang" autofocus>
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

        {{-- <script>
            let formCounter = 1;

            function addForm() {
                formCounter++;

                const formContainer = document.getElementById('form-container');
                const newForm = document.createElement('div');
                newForm.innerHTML = `
                
                    <div class="mb-3">
                        <label for="exampleFormControlInput${formCounter}" class="form-label">Kode</label>
                        <input type="text" class="form-control" name="kode[]" id="kode_${formCounter}" placeholder="Kode Barang">
                    </div>
                
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_barang[]" placeholder="Nama Barang">
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

            $(document).ready(function() {
        generateKodeOtomatis(); // Panggil fungsi saat halaman dimuat

        function generateKodeOtomatis() {
            // Panggil endpoint di server untuk mengambil data kode barang terakhir
            $.ajax({
                url: '/get_last_kode_barang', // Ubah sesuai dengan URL endpoint Anda
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        let lastKode = response.data.kode;
                        let currentNumber = parseInt(lastKode.substr(3));
                        let nextNumber = currentNumber + 1;
                        let nextKode = 'BRG' + nextNumber.toString().padStart(3, '0');
                        document.getElementById(`kode_${formNumber}`).value = nextKode;
                        $('#kode').val(nextKode);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });
        </script> --}}
        <script>
            let formCounter = 1;
    
            // Panggil fungsi generateKodeOtomatis saat halaman dimuat
            window.onload = function() {
                generateKodeOtomatis();
            };
    
            // Fungsi untuk menambahkan form baru
            function addForm() {
                formCounter++;
    
                const formContainer = document.getElementById('form-container');
                const newForm = document.createElement('div');
                newForm.innerHTML = `
                <br>
                    <div class="form-group">
                        <label for="kode_${formCounter}" class="mb-2">Kode Barang:</label>
                        <input type="text" class="form-control kode-input" id="kode_${formCounter}" name="kode[]">
                    </div>
                    <br>
                    <div class="mb-3 row">
                        <label for="nama_${formCounter}" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_${formCounter}" name="nama_barang[]" placeholder="Nama Barang" autofocus>
                        </div>
                    </div>
                    <br>
                    <button type="button" onclick="removeForm(this)" class="btn btn-danger mb-3">Hapus Form</button>
                `;
    
                formContainer.appendChild(newForm);
    
                // Jalankan generateKodeOtomatis untuk form baru yang ditambahkan
                generateKodeOtomatis(formCounter);
            }
    
            // Fungsi untuk menghapus form
            function removeForm(button) {
                const formContainer = document.getElementById('form-container');
                formContainer.removeChild(button.parentNode);
                generateKodeOtomatis();
            }
    
            // Fungsi untuk generate kode otomatis berdasarkan nomor form
            function generateKodeOtomatis(formNumber) {
                // Dapatkan semua input kode
                const kodeInputs = document.getElementsByClassName('kode-input');
                // Panggil endpoint di server untuk mengambil data kode barang terakhir
                $.ajax({
                    url: '/get_last_kode_barang', // Ubah sesuai dengan URL endpoint Anda
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let lastKode = response.data.kode;
                            let currentNumber = parseInt(lastKode.substr(3));
                            // let nextNumber = currentNumber + formNumber; // Sesuaikan penambahan angka berdasarkan nomor form
                            // let nextKode = 'BRG' + nextNumber.toString().padStart(3, '0');

                            // Update nilai kode otomatis untuk setiap form
                            for (let i = 0; i < kodeInputs.length; i++) {
                                let formNumber = i + 1;
                                let nextNumber = currentNumber + formNumber;
                                let nextKode = 'BRG' + nextNumber.toString().padStart(3, '0');
                                kodeInputs[i].value = nextKode;
                            }
    
                        
                            $('#kode_' + formNumber).val(nextKode);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        </script>
    </form>
    <br>
</div>


@endsection