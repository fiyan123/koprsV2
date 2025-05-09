@extends('layouts.admin')

@section('title', 'Edit Password')

@section('breadcrumb')
  <x-dashboard.breadcrumb title="Edit Password" page="Dashboard" active="Edit Password" route="{{ route('dashboard') }}" />
@endsection

@section('content')
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Form Edit Password</h4>
        <form method="POST" action="{{ route('anggota.updatePassword', $user->id) }}">
          @csrf
          @method('PATCH')

          <div class="form-group">
            <label for="password" class="form-label text-start">Password Baru</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password Baru" required>
          </div>

        <div class="form-group">
            <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Konfirmasi Password Baru" required>
          </div>

          <button type="submit" class="btn btn-primary mr-2">Perbarui</button>
          <a href="{{ route('anggota.index') }}" class="btn btn-light">Batal</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
