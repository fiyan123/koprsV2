@extends('layouts.admin')

@section('title', 'Detail Simpanan dan Profil Anggota')

@section('breadcrumb')
    <x-dashboard.breadcrumb title="Detail Simpanan" page="Simpanan" active="Detail" route="{{ route('simpanan.index') }}" />
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
                        {{ $simpanan->nama }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong><br>
                        {{ $simpanan->email }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>NIP:</strong><br>
                        {{ $simpanan->nip ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>No. HP:</strong><br>
                        {{ $simpanan->no_hp }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Tanggal Lahir:</strong><br>
                        {{ \Carbon\Carbon::parse($simpanan->tgl_lahir)->format('d-m-Y') }}
                    </div>
                    <div class="col-md-12 mb-3">
                        <strong>Alamat:</strong><br>
                        {{ $simpanan->alamat ?? '-' }}
                    </div>
                </div>

                <hr class="my-4">
                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Detail Simpanan</h4>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2"><strong>Nama Simpanan:</strong> {{ $simpanan->nama }}</div>
                    <div class="col-md-6 mb-2"><strong>Jumlah:</strong> Rp{{ number_format($simpanan->jumlah, 0, ',', '.') }}</div>
                    {{-- <div class="col-md-6 mb-2"><strong>Jenis Simpanan:</strong> {{ ucfirst($simpanan->jenis_simpanan) }}</div> --}}
                    <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $simpanan->email }}</div>
                    <div class="col-md-6 mb-2"><strong>NIP:</strong> {{ $simpanan->nip }}</div>
                    <div class="col-md-6 mb-2"><strong>No. HP:</strong> {{ $simpanan->no_hp }}</div>
                    <div class="col-md-6 mb-2"><strong>Alamat:</strong> {{ $simpanan->alamat }}</div>
                    @if ($simpanan->status === 'tarik')
                        <div class="col-md-6 mb-2"><strong>No Rek:</strong> {{ $simpanan->no_rek }}</div>
                        @endif
                        <div class="col-md-6 mb-2"><strong>Sisa Saldo:</strong> {{ $sisa_saldo }}</div>
                </div>

                <hr class="my-4">

                <h4 class="card-title mb-3">Riwayat Simpanan</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                {{-- <th>Jenis Simpanan</th> --}}
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                @if ($simpanan->status === 'simpan')
                                <th>Bukti Transfer</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                {{-- <td>{{ ucfirst($simpanan->jenis_simpanan) }}</td> --}}
                                <td>Rp{{ number_format($simpanan->jumlah ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $simpanan->created_at ? \Carbon\Carbon::parse($simpanan->created_at)->format('d-m-Y') : '-' }}</td>
                                <td>{{ ucfirst($simpanan->status) }}</td>
                                @if($simpanan->status === 'simpan')
                                <td>
                                        @if($simpanan->bukti_tf)
                                            <a href="{{ asset('/storage/'.$simpanan->bukti_tf) }}" target="_blank">Lihat</a>
                                        @else
                                            <span class="text-muted">Belum ada</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                    </table>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('simpanan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
