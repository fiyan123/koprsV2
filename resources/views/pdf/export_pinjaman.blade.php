<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pinjaman</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        h2,
        h4 {
            text-align: center;
            margin-bottom: 10px;
        }

        .summary {
            margin-top: 20px;
            text-align: left
        }
    </style>
</head>

<body>
    <h2 class="mb-4">LAPORAN PINJAMAN KOPERASI</h2>
    @if ($tahun && $bulan)
        <h4>Periode: {{ $bulan }} / {{ $tahun }}</h4>
    @endif
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>User ID</th>
                <th>Jumlah Pinjaman</th>
                <th>Total Bayar</th>
                <th>Denda</th>
                <th>Bunga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($laporan['data'] as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $row->user_id }}</td>
                    <td>{{ number_format($row->jumlah_Pinjaman, 2) }}</td>
                    <td>{{ number_format($row->total_bayar_Pinjaman, 2) }}</td>
                    <td>{{ number_format($row->jumlah_denda, 2) }}</td>
                    <td>{{ $row->bunga }}%</td>
                    <td>{{ ucfirst($row->status_pinjaman) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h4>Ringkasan Total</h4>
        <table>
            <tr>
                <th>Jumlah Pinjaman</th>
                <td>{{ $laporan['total_jumlah_pinjaman_all'] }}</td>
            </tr>
            <tr>
                <th>Jumlah Pembayaran</th>
                <td>{{ $laporan['total_bayar_pinjaman_all'] }}</td>
            </tr>
            <tr>
                <th>Denda</th>
                <td>{{ $laporan['total_jumlah_denda_all'] }}</td>
            </tr>
            <tr>
                <th>Keuntungan</th>
                <td>{{ $laporan['total_jumlah_keuntungan'] }}</td>
            </tr>
            <tr>
                <th>Total Anggota</th>
                <td>{{ $laporan['total_user_pinjaman_all'] }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
