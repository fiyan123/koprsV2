@extends('layouts.admin')

@section('title', 'Detail Pinjaman dan Profil Anggota')

@section('breadcrumb')
    <x-dashboard.breadcrumb title="Detail Pinjaman" page="Pinjaman" active="Detail" route="{{ route('pinjaman.index') }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Profil Anggota</h4>
                <div class="row">
                    <!-- Informasi User -->
                    <div class="col-md-6 mb-3">
                        <strong>Nama:</strong><br>
                        {{ $pinjaman->user_name }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong><br>
                        {{ $pinjaman->user_email }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>NIP:</strong><br>
                        {{ $pinjaman->nip ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>No. KTP:</strong><br>
                        {{ $pinjaman->no_ktp }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>No. HP:</strong><br>
                        {{ $pinjaman->no_hp }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Tanggal Lahir:</strong><br>
                        {{ \Carbon\Carbon::parse($pinjaman->tgl_lahir)->format('d-m-Y') }}
                    </div>
                    <div class="col-md-12 mb-3">
                        <strong>Alamat:</strong><br>
                        {{ $pinjaman->alamat ?? '-' }}
                    </div>

                    <!-- Foto Section -->
                    <div class="col-md-4 text-center mb-3">
                        <strong>Foto Profil</strong><br>
                        @if($pinjaman->foto)
                            <img src="{{ asset('storage/'.$pinjaman->foto) }}" class="img-fluid rounded shadow" style="max-height: 200px;">
                        @else
                            <p class="text-muted">Tidak ada foto</p>
                        @endif
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <strong>Foto KTP</strong><br>
                        @if($pinjaman->foto_ktp)
                            <img src="{{ asset('storage/'.$pinjaman->foto_ktp) }}" class="img-fluid rounded shadow" style="max-height: 200px;">
                        @else
                            <p class="text-muted">Tidak ada foto</p>
                        @endif
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <strong>Foto dengan KTP</strong><br>
                        @if($pinjaman->foto_dengan_ktp)
                            <img src="{{ asset('storage/'.$pinjaman->foto_dengan_ktp) }}" class="img-fluid rounded shadow" style="max-height: 200px;">
                        @else
                            <p class="text-muted">Tidak ada foto</p>
                        @endif
                    </div>
                </div>

                <hr class="my-4">
                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Detail Pinjaman</h4>
                    @if ($sisaAngsuran)
                        <span class="badge bg-warning text-dark">Belum Lunas</span>
                    @else
                        <span class="badge bg-success">Lunas</span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2"><strong>Nama Pinjaman:</strong> {{ $pinjaman->nama_pinjaman }}</div>
                    <div class="col-md-6 mb-2"><strong>Jumlah:</strong> Rp{{ number_format($pinjaman->jumlah, 0, ',', '.') }}</div>
                    <div class="col-md-6 mb-2"><strong>Durasi:</strong> {{ $pinjaman->durasi }} {{ $pinjaman->tipe_durasi }}</div>
                    <div class="col-md-6 mb-2"><strong>Bunga:</strong> {{ $pinjaman->bunga }}%</div>
                    <div class="col-md-6 mb-2"><strong>Total Bunga:</strong> Rp{{ number_format($pinjaman->total_bunga, 0, ',', '.') }}</div>
                    <div class="col-md-6 mb-2"><strong>Total Pembayaran:</strong> Rp{{ number_format($pinjaman->total_pembayaran, 0, ',', '.') }}</div>
                    <div class="col-md-6 mb-2"><strong>Cicilan per Pembayaran:</strong> Rp{{ number_format($pinjaman->cicilan_pembayaran, 0, ',', '.') }}</div>
                    <div class="col-md-6 mb-2"><strong>Status:</strong> {{ ucfirst($pinjaman->status) }}</div>
                    <div class="col-md-6 mb-2"><strong>Status Pinjaman:</strong> {{ ucfirst($pinjaman->status_pinjaman) }}</div>
                    <div class="col-md-6 mb-2"><strong>Sisa Angsuran:</strong> {{ $sisaAngsuran }} kali</div>
                    <div class="col-md-6 mb-2"><strong>Total Denda:</strong> Rp{{ number_format($totalDenda, 0, ',', '.') }}</div>
                    <div class="col-md-6 mb-2"><strong>Total Jumlah Denda:</strong> {{ $totalJumlahDenda }}</div>

                </div>

                <hr class="my-4">

                <h4 class="card-title mb-3">Riwayat Angsuran</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Angsuran ke</th>
                                <th>Jumlah Dibayar</th>
                                <th>Tanggal Bayar</th>
                                <th>Bukti Transfer</th>
                                <th>jumlah Denda</th> <!-- Kolom Denda -->
                                <th>Total Denda</th> <!-- Kolom Denda -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($angsuranList as $index => $angsuran)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $angsuran->angsuran_ke }}</td>
                                <td>Rp{{ number_format($angsuran->jumlah_dibayar ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $angsuran->tanggal_bayar ? \Carbon\Carbon::parse($angsuran->tanggal_bayar)->format('d-m-Y') : '-' }}</td>
                                <td>
                                    @if($angsuran->bukti_transfer)
                                        <a href="{{ asset($angsuran->bukti_transfer) }}" target="_blank">Lihat</a>
                                    @else
                                        <span class="text-muted">Belum ada</span>
                                    @endif
                                </td>
                                <td>  {{ ($angsuran->total_denda) }}</td> <!-- Menampilkan Denda per Angsuran -->
                                <td>Rp{{ number_format($angsuran->denda ?? 0, 0, ',', '.') }}</td> <!-- Menampilkan Denda per Angsuran -->
                            </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">Belum ada angsuran</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <div class="text-end mt-4">
                    <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
