<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Simpanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
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
        }

        .summary {
            margin-top: 20px;
            text-align: left
        }
    </style>
</head>

<body>
    <h2>LAPORAN SIMPANAN KOPERASI</h2>
    @if ($tahun && $bulan)
        <h4>Periode: {{ $bulan }} / {{ $tahun }}</h4>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User ID</th>
                <th>Saldo Akhir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($data as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item['user_id'] }}</td>
                    <td>Rp {{ number_format($item['saldo_akhir'], 0, ',', '.') }}</td>
                    <td>{{ $item['status'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h4>Ringkasan Total</h4>
        <table>
            <tr>
                <th>Total User (Simpan)</th>
                <td>{{ $total_all['count_user_simpan'] }}</td>
            </tr>
            <tr>
                <th>Total User (Tarik)</th>
                <td>{{ $total_all['count_user_tarik'] }}</td>
            </tr>
            <tr>
                <th>Total User (Potong)</th>
                <td>{{ $total_all['count_user_potong'] }}</td>
            </tr>
            <tr>
                <th>Total User Keseluruhan</th>
                <td>{{ $total_all['count_user_all'] }}</td>
            </tr>
            <tr>
                <th>Jumlah Simpanan</th>
                <td>Rp {{ number_format($total_all['count_jumlah_simpan'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Jumlah Tarikan</th>
                <td>Rp {{ number_format($total_all['count_jumlah_tarik'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Jumlah Pemotongan</th>
                <td>Rp {{ number_format($total_all['count_jumlah_potong'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Jumlah Akhir (Saldo Keseluruhan)</th>
                <td>Rp {{ number_format($total_all['count_jumlah_all'], 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
