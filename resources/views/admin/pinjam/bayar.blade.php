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

        <form method="POST" action="{{ route('pinjaman.proses_bayar', $pinjaman->id) }}" enctype="multipart/form-data" id="formBayar">
          @csrf
          @method('PATCH')

          <div class="form-group">
            <label for="angsuran_ke">Angsuran Ke</label>
            <input type="text" class="form-control" value="{{ $angsuran->angsuran_ke }}" readonly>
          </div>

          <div class="form-group">
            <label for="jatuh_tempo">Jatuh Tempo</label>
            <input type="text" class="form-control" value="{{ $angsuran->jatuh_tempo }}" readonly>
          </div>

          <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
              <option value="transfer">Transfer</option>
              <option value="tabungan">Tabungan / Simpanan</option>
            </select>
          </div>

          <div class="form-group">
            <label for="jumlah_dibayar">Jumlah Dibayar (Rp)</label>
            <input type="text" id="jumlah_dibayar" class="form-control" value="Rp {{ number_format($jumlahDibayar, 0, ',', '.') }}" readonly>
          </div>

          {{-- Ini akan ditampilkan jika metode "tabungan" dipilih --}}
          <div class="form-group" id="saldoContainer" style="display: none;">
            <label>Saldo Anda</label>
            <input type="text" class="form-control" value="Rp {{ number_format($saldo, 0, ',', '.') }}" readonly>
            <small id="errorSaldo" class="text-danger" style="display: none;">Saldo tabungan tidak mencukupi untuk melakukan pembayaran.</small>
          </div>

          {{-- Ini akan disembunyikan jika metode "tabungan" dipilih --}}
          <div class="form-group" id="buktiTransferContainer">
            <label for="bukti_transfer">Bukti Transfer</label>
            <input type="file" name="bukti_transfer" class="form-control" id="bukti_transfer">
          </div>

          <button type="submit" class="btn btn-success" id="submitBtn">Bayar Sekarang</button>
          <a href="{{ route('pinjaman.index') }}" class="btn btn-light">Batal</a>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const metodeSelect = document.getElementById('metode_pembayaran');
  const buktiTransferContainer = document.getElementById('buktiTransferContainer');
  const saldoContainer = document.getElementById('saldoContainer');
  const errorSaldo = document.getElementById('errorSaldo');
  const submitBtn = document.getElementById('submitBtn');

  const saldo = {{ $saldo }};
  const jumlahDibayar = {{ $jumlahDibayar }};

  metodeSelect.addEventListener('change', function () {
    const metode = metodeSelect.value;

    if (metode === 'tabungan') {
      buktiTransferContainer.style.display = 'none';
      saldoContainer.style.display = 'block';

      if (saldo < jumlahDibayar) {
        errorSaldo.style.display = 'block';
        submitBtn.disabled = true;
      } else {
        errorSaldo.style.display = 'none';
        submitBtn.disabled = false;
      }

    } else {
      buktiTransferContainer.style.display = 'block';
      saldoContainer.style.display = 'none';
      errorSaldo.style.display = 'none';
      submitBtn.disabled = false;
    }
  });
});
</script>

@endsection
