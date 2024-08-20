<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Invoice</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray;
        }

        .details-table td {
            padding: 5px;
        }
    </style>

</head>

<body>
    <?php
    // Ubah logo menjadi base64
    $path = public_path('img/' . $site->logo);
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>
    @php
        if ($transaksi->status == 0) {
            $text = 'Menunggu pembayaran';
            $color = 'blue';
        } elseif ($transaksi->status == 1) {
            $text = 'Pembayaran berhasil';
            $color = 'DarkGreen';
        } elseif ($transaksi->status == 2) {
            $text = 'Belum Diverifikasi';
            $color = 'coral';
        } elseif ($transaksi->status == 4) {
            $text = 'Belum upload';
            $color = 'orange';
        } elseif ($transaksi->status == 3) {
            $text = 'Batal';
            $color = 'red';
        }
    @endphp

    <table width="100%">
        <tr>
            <td valign="top">
                <img src="{{ $base64 }}" alt="Logo" width="80" />
            </td>
            <td align="right">
                <h3>{{ $site->name }}</h3>
                <pre>
                {{ $site->name }}
                {{ $site->address }}
                {{ $site->phone }}
            </pre>
            </td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td><strong>Dari:</strong> {{ $site->name }} - {{ $site->phone }}</td>
            <td><strong>Untuk:</strong> {{ $transaksi->nama }} - {{ $transaksi->no_hp }}</td>
        </tr>
    </table>

    <br />

    <table class="table table-bordered">
        <thead style="background-color: lightgray;">
            <tr>
                <th colspan="2">Detail Pemesanan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Kode Pemesanan</strong></td>
                <td>{{ $transaksi->kode }}</td>
            </tr>
            <tr>
                <td><strong>Nama</strong></td>
                <td>{{ $transaksi->nama }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>{{ $transaksi->email }}</td>
            </tr>
            <tr>
                <td><strong>No HP</strong></td>
                <td>{{ $transaksi->no_hp }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Pemesanan</strong></td>
                <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Kedatangan</strong></td>
                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Keperluan</strong></td>
                <td>{{ $transaksi->keperluan }}</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td>@currency($transaksi->product_price)</td>
            </tr>
            <tr>
                <td><strong>Metode Pembayaran</strong></td>
                <td>{{ $transaksi->bank_name }} - {{ $transaksi->no_rekening }}</td>
            </tr>
            <tr>
                <td><strong>Status Pembayaran:</strong></td>
                <td style="background-color: {{ $color }}; padding:5px; color: white;">{{ $text }}</td>
            </tr>
        </tbody>
    </table>
    <br />
    <p align="center"><b>Silahkan simpan nota ini</b></p>
</body>

</html>