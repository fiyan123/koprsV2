@extends('layouts.admin')

@section('title', 'Tambah Anggota')

@section('breadcrumb')
  <x-dashboard.breadcrumb title="Tambah Anggota" page="Dashboard" active="Tambah Anggota" route="{{ route('dashboard') }}" />
@endsection

@section('content')
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Form Tambah Anggota</h4>
        <form method="POST" action="{{ route('anggota.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Alamat Email" value="{{ old('email') }}" required>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>

          <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required>
          </div>

          <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai" value="{{ old('nip') }}">
          </div>

          <div class="form-group">
            <label for="no_ktp">No. KTP</label>
            <input type="text" name="no_ktp" class="form-control" placeholder="Nomor KTP" value="{{ old('no_ktp') }}">
          </div>

          <div class="form-group">
            <label for="tgl_lahir">Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control" value="{{ old('tgl_lahir') }}">
          </div>

          <div class="form-group">
            <label for="no_hp">No. HP</label>
            <input type="text" name="no_hp" class="form-control" placeholder="Nomor Handphone" value="{{ old('no_hp') }}">
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
          </div>

          <div class="form-group">
            <label for="foto">Foto Profil</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
          </div>

          <div class="form-group">
            <label for="foto_ktp">Foto KTP</label>
            <input type="file" name="foto_ktp" class="form-control" accept="image/*" required>
          </div>

          <div class="form-group">
            <label for="foto_dengan_ktp">Foto dengan KTP</label>
            <input type="file" name="foto_dengan_ktp" class="form-control" accept="image/*" required>
          </div>

          <button type="submit" class="btn btn-primary mr-2">Simpan</button>
          <a href="{{ route('anggota.index') }}" class="btn btn-light">Batal</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
