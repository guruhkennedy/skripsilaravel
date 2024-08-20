<!DOCTYPE html>
<html lang="en">

<head>
    <!-- metas -->
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="form-group">
        <p align="center"><b>Laporan Penghasilan</b></p>
        <div class="mt-2 mb-2">
            <p><b>Total pendapatan dari tanggal <span class="text-danger">{{ $bulanawal }}</span> sampai tanggal <span class="text-danger">{{ $bulanakhir }}</span> adalah <span class="text-danger">@currency($totalSum)</span></b></p>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Kode Pemesanan</th>
                <th>Nama</th>
                <th>No Hp</th>
                <th>Tanggal Pemesanan</th>
                <th>Tanggal Kedatangan</th>
                <th>Keperluan</th>
                <th>Total</th>
            </tr>
            @foreach ($cetaklaporan as $reservasi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $reservasi->kode }}</td>
                    <td>{{ $reservasi->nama }}</td>
                    <td>{{ $reservasi->no_hp }}</td>
                    <td>{{ \Carbon\Carbon::parse($reservasi->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                    <td>{{ \Carbon\Carbon::parse($reservasi->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                    <td>{{ $reservasi->keperluan }}</td>
                    <td>@currency($reservasi->total)</td>
                </tr>
            @endforeach
        </table>
        
        <p align="center"><b>Dicetak dari: <a href="{{ $currentUrl }}">{{ $currentUrl }}</a></b></p>
    </div>
</body>
</html>
