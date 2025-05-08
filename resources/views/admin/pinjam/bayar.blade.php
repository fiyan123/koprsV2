@extends('layouts.admin')

@section('title', 'Bayar Angsuran')

@section('breadcrumb')
  <x-dashboard.breadcrumb title="Bayar Angsuran" page="Pinjaman" active="Bayar Angsuran" route="{{ route('pinjaman.index') }}" />
@endsection

@section('content')
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Form Bayar Angsuran</h4>

        <form method="POST" action="{{ route('pinjaman.proses_bayar', $pinjaman->id) }}" enctype="multipart/form-data">
            @csrf
          @method('PATCH') <!-- Use PATCH method here -->

          <div class="form-group">
            <label for="angsuran_ke">Angsuran Ke</label>
            <input type="text" class="form-control" value="{{ $angsuran->angsuran_ke }}" readonly>
          </div>

          <div class="form-group">
            <label for="jatuh_tempo">Jatuh Tempo</label>
            <input type="text" class="form-control" value="{{ $angsuran->jatuh_tempo }}" readonly>
          </div>

          <div class="form-group">
            <label for="jumlah_dibayar">Jumlah Dibayar (Rp)</label>
            <input type="text" class="form-control" value="Rp {{ number_format($jumlahDibayar, 0, ',', '.') }}" readonly>
          </div>

          <div class="form-group">
            <label for="bukti_transfer">Bukti Transfer</label>
            <input type="file" name="bukti_transfer" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-success">Bayar Sekarang</button>
          <a href="{{ route('pinjaman.index') }}" class="btn btn-light">Batal</a>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
  // Set tanggal bayar otomatis ke tanggal sekarang
  window.onload = function() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_bayar').value = today; // Update this line if you need to set the date field
  };
</script>

@endsection
