<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .info {
            width: 40%;
        }
        .info h4 {
            margin-top: 0;
            margin-bottom: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .items-table th,
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>INVOICE</h1>
            <p><b>{{ ($transaksis->kode_transaksi) }}</b></p>
            <p>Date: {{ Date('d M Y') }}</p>
        </div>
        <div class="invoice-details">
            <div class="info">
                <h4>From:</h4>
                <p>Your Company Name<br>123 Main Street<br>City, Country</p>
            </div>
            <div class="info">
                <h4>To:</h4>
                <p>Client's Name<br>456 Customer Ave<br>City, Country</p>
            </div>
        </div>
        <table class="items-table">
            <tr>
                {{-- <th scope="col">Jenis Transaksi</th> --}}
                {{-- <th scope="col">Kode Transaksi</th> --}}
                <th scope="col">Nama Barang</th>
                <th scope="col">Total Item</th>
                <th scope="col">Harga</th>
                <th scope="col">Total</th>
            </tr>
            
            @foreach ($transaksi as $duplicate)
            <tr>
                {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                {{-- <td>{{ ($duplicate->jenis_transaksi) }}</td> --}}
                {{-- <td>{{ ($duplicate->kode_transaksi) }}</td>                             --}}
                <td>{{ ($duplicate->barang->name) }}</td>                            
                <td>{{ ($duplicate->jumlah) }}</td>
                <td>{{ number_format( $duplicate->harga, 0, ',', '.') }}</td>
                <td>{{ number_format($duplicate->harga * $duplicate->jumlah , 0, ',', '.') }}</td>
            </tr>
            @endforeach
                
                @php
                $total_harga = 0;
                    foreach ($transaksi as $duplicate) {
                        $total_harga += ($duplicate->harga * $duplicate->jumlah);
                    }        
                @endphp                
                
            <tr>
                {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                <th scope="col">Total</th>
                <th scope="col">{{ ($transaksi->sum('jumlah')) }}</th>
                {{-- <th scope="col"></th> --}}
                <th scope="col"></th>
                <th scope="col">{{ number_format($total_harga, 0, ',', '.') }}</th>
            </tr>
            <!-- Add more items here -->
        </table>
        <div class="total">
            {{-- <p>Total: {{ number_format($total_harga, 0, ',', '.') }}</p> --}}
        </div>
    </div>
</body>
</html>
