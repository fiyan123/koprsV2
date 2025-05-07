@extends('layouts.admin')
@section('title', 'Tambah Saldo Koperasi')
@section('breadcrumb')
    <x-dashboard.breadcrumb title="Tambah Saldo Koperasi" page="Home" active="Tambah Saldo" route="{{ route('home') }}" />
@endsection

@section('content')

<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Form Saldo Koperasi</h4>
        <form method="POST" action="{{ route('saldo.store') }}">
          @csrf

          <div class="form-group">
            <label for="jumlah_saldo">Jumlah Saldo (Rp)</label>
            <input type="text" name="jumlah_saldo" class="form-control" id="jumlah_saldo" placeholder="Misal: 1.000.000" required>
            @error('jumlah_saldo')
              <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)"></textarea>
          </div>

          <button type="submit" class="btn btn-primary mr-2">Submit</button>
          <a href="{{ route('saldo.index') }}" class="btn btn-light">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('jumlah_saldo').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    let formatted = new Intl.NumberFormat('id-ID').format(value);
    e.target.value = formatted;
  });
</script>

@endsection
