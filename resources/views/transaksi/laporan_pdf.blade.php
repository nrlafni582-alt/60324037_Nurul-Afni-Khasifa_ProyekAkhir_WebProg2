<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Transaksi</title>

    <style>

        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
        }

        table th {
            background: #f2f2f2;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            margin-top: 20px;
        }

    </style>

</head>

<body>

    <h2>Laporan Transaksi Perpustakaan</h2>

    <p>
        Tanggal Cetak :
        {{ now()->format('d-m-Y H:i') }}
    </p>

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Denda</th>

            </tr>

        </thead>

        <tbody>

            @forelse ($transaksis as $transaksi)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $transaksi->kode_transaksi }}
                    </td>

                    <td>
                        {{ $transaksi->anggota->nama }}
                    </td>

                    <td>
                        {{ $transaksi->buku->judul }}
                    </td>

                    <td>
                        {{ $transaksi->tanggal_pinjam->format('d-m-Y') }}
                    </td>

                    <td class="text-center">
                        {{ $transaksi->status }}
                    </td>

                    <td>
                        Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="text-center">
                        Tidak ada data transaksi.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="summary">

        <p>

            <strong>Total Transaksi :</strong>
            {{ $transaksis->count() }}

        </p>

        <p>

            <strong>Total Denda :</strong>
            Rp {{ number_format($totalDenda, 0, ',', '.') }}

        </p>

    </div>

</body>

</html>