@extends('layouts.admin')
@section('title', 'Tambah Simpanan')
@section('breadcrumb')
    <x-dashboard.breadcrumb title="Tambah Simpanan" page="Home" active="Tambah Simpanan" route="{{ route('home') }}" />
@endsection

@section('content')
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Form Tambah Simpanan</h4>
        <form method="POST" action="{{ route('simpanan.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" class="form-control" required>
              <option value="">Pilih User</option>
              @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" name="nip" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="no_hp">No. HP</label>
            <input type="text" name="no_hp" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="jenis_simpanan">Jenis Simpanan</label>
            <select name="jenis_simpanan" class="form-control" required>
              <option value="pokok">Pokok</option>
              <option value="wajib">Wajib</option>
              <option value="sukarela">Sukarela</option>
              <option value="berjangka">Berjangka</option>
            </select>
          </div>

          <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="bukti_tf">Bukti Transfer</label>
            <input type="file" name="bukti_tf" class="form-control">
          </div>

          <button type="submit" class="btn btn-primary mr-2">Submit</button>
          <a href="{{ route('simpanan.index') }}" class="btn btn-light">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
