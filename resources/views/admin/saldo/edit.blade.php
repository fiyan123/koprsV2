@extends('layouts.admin')
@section('title', 'Edit Saldo Koperasi')
@section('breadcrumb')
    <x-dashboard.breadcrumb title="Edit Saldo Koperasi" page="Home" active="Edit Saldo" route="{{ route('home') }}" />
@endsection

@section('content')

<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Form Edit Saldo Koperasi</h4>
        <form method="POST" action="{{ route('saldo.update', $saldo->id) }}">
            @csrf
            @method('PATCH') <!-- Change PUT to PATCH here -->

            <!-- Jumlah Saldo Field -->
            <div class="form-group">
                <label for="jumlah_saldo">Jumlah Saldo (Rp)</label>
                <input type="text" name="jumlah_saldo" class="form-control" id="jumlah_saldo" value="{{ number_format($saldo->jumlah_saldo, 0, ',', '.') }}" required>
                @error('jumlah_saldo')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Deskripsi Field -->
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)">{{ $saldo->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <a href="{{ route('saldo.index') }}" class="btn btn-light">Cancel</a>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
  // Automatically format the input as currency with dots
  document.getElementById('jumlah_saldo').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove any non-digit characters
    let formatted = new Intl.NumberFormat('id-ID').format(value); // Format the value
    e.target.value = formatted;
  });
</script>

@endsection
