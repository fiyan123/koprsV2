@extends('layouts.admin')

@section('title', 'Detail Anggota')

@section('breadcrumb')
    <x-dashboard.breadcrumb title="Detail Anggota" page="Anggota" active="Detail" route="{{ route('anggota.index') }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Profil Lengkap Anggota</h4>
                <div class="row">
                    <!-- Informasi Umum -->
                    <div class="col-md-6 mb-3">
                        <strong>Nama:</strong><br>
                        {{ $user->name }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong><br>
                        {{ $user->email }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>NIP:</strong><br>
                        {{ $user->nip ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>No. KTP:</strong><br>
                        {{ $user->no_ktp }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>No. HP:</strong><br>
                        {{ $user->no_hp }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Tanggal Lahir:</strong><br>
                        {{ \Carbon\Carbon::parse($user->tgl_lahir)->format('d-m-Y') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Alamat:</strong><br>
                        {{ $user->alamat ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Saldo:</strong><br>
                        {{ $user->saldo_akhir ?? '-' }}
                    </div>

                    <!-- Foto Section -->
                    <div class="col-md-4 text-center mb-3">
                        <strong>Foto Profil</strong><br>
                        @if($user->foto)
                            <img src="{{ asset('storage/'.$user->foto) }}" alt="Foto Profil" class="img-fluid rounded shadow" style="max-height: 200px;">
                        @else
                            <p class="text-muted">Tidak ada foto</p>
                        @endif
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <strong>Foto KTP</strong><br>
                        @if($user->foto_ktp)
                            <img src="{{ asset('storage/'.$user->foto_ktp) }}" alt="Foto KTP" class="img-fluid rounded shadow" style="max-height: 200px;">
                        @else
                            <p class="text-muted">Tidak ada foto</p>
                        @endif
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <strong>Foto dengan KTP</strong><br>
                        @if($user->foto_dengan_ktp)
                            <img src="{{ asset('storage/'.$user->foto_dengan_ktp) }}" alt="Foto dengan KTP" class="img-fluid rounded shadow" style="max-height: 200px;">
                        @else
                            <p class="text-muted">Tidak ada foto</p>
                        @endif
                    </div>
                </div>
                <div class="text-end mt-4">
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
