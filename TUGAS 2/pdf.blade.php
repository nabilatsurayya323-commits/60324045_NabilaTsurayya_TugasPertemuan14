<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>

    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        table, th, td{
            border:1px solid #000;
        }

        th, td{
            padding:8px;
            text-align:left;
        }

        h2{
            text-align:center;
        }
    </style>
</head>

<body>

<h2>Laporan Transaksi Perpustakaan</h2>

<table>

    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Status</th>
            <th>Denda</th>
        </tr>
    </thead>

    <tbody>

    @foreach($transaksis as $transaksi)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $transaksi->kode_transaksi }}</td>

            <td>{{ $transaksi->anggota->nama }}</td>

            <td>{{ $transaksi->buku->judul }}</td>

            <td>{{ $transaksi->tanggal_pinjam->format('d-m-Y') }}</td>

            <td>{{ $transaksi->status }}</td>

            <td>Rp {{ number_format($transaksi->denda,0,',','.') }}</td>

        </tr>

    @endforeach

    </tbody>

</table>

<br>

<h3>Total Transaksi : {{ $transaksis->count() }}</h3>

<h3>Total Denda : Rp {{ number_format($totalDenda,0,',','.') }}</h3>

</body>
</html>