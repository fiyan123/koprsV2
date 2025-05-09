@extends('layouts.admin')

@section('title', 'Detail User')

@section('breadcrumb')
    <x-dashboard.breadcrumb title="Detail User" page="Halaman User" active="Detail" route="{{ route('home') }}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Profil Lengkap User</h4>
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
                        <div class="col-md-12 mb-3">
                            <strong>Alamat:</strong><br>
                            {{ $user->alamat ?? '-' }}
                        </div>

                        <!-- Foto Section -->
                        <div class="col-md-4 text-center mb-3">
                            <strong>Foto Profil</strong><br>
                            @if ($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                                    class="img-fluid rounded shadow" style="max-height: 200px;">
                            @else
                                <p class="text-muted">Tidak ada foto</p>
                            @endif
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <strong>Foto KTP</strong><br>
                            @if ($user->foto_ktp)
                                <img src="{{ asset('storage/' . $user->foto_ktp) }}" alt="Foto KTP"
                                    class="img-fluid rounded shadow" style="max-height: 200px;">
                            @else
                                <p class="text-muted">Tidak ada foto</p>
                            @endif
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <strong>Foto dengan KTP</strong><br>
                            @if ($user->foto_dengan_ktp)
                                <img src="{{ asset('storage/' . $user->foto_dengan_ktp) }}" alt="Foto dengan KTP"
                                    class="img-fluid rounded shadow" style="max-height: 200px;">
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

    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Edit Profil User</h4>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Informasi Umum -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" name="nip" value="{{ old('nip', $user->nip) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="no_ktp" class="form-label">No. KTP</label>
                        <input type="text" class="form-control" name="no_ktp"
                            value="{{ old('no_ktp', $user->no_ktp) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="no_hp" class="form-label">No. HP</label>
                        <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir"
                            value="{{ old('tgl_lahir', $user->tgl_lahir) }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    <!-- Foto Upload -->
                    <div class="col-md-4 mb-3">
                        <label for="foto" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" name="foto">
                        @if ($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" class="img-fluid mt-2"
                                style="max-height: 150px;">
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="foto_ktp" class="form-label">Foto KTP</label>
                        <input type="file" class="form-control" name="foto_ktp">
                        @if ($user->foto_ktp)
                            <img src="{{ asset('storage/' . $user->foto_ktp) }}" class="img-fluid mt-2"
                                style="max-height: 150px;">
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="foto_dengan_ktp" class="form-label">Foto dengan KTP</label>
                        <input type="file" class="form-control" name="foto_dengan_ktp">
                        @if ($user->foto_dengan_ktp)
                            <img src="{{ asset('storage/' . $user->foto_dengan_ktp) }}" class="img-fluid mt-2"
                                style="max-height: 150px;">
                        @endif
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
