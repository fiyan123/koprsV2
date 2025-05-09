@extends('layouts.admin')

@section('title', 'Edit Simpanan')

@section('breadcrumb')
  <x-dashboard.breadcrumb title="Edit Simpanan" page="Dashboard" active="Edit Simpanan" route="{{ route('dashboard') }}" />
@endsection

@section('content')
@php
  $simpan = DB::table('simpanans')->where('status','simpan')->where('user_id', auth()->id())->sum('jumlah');
  $tarik = DB::table('simpanans')->where('status','tarik')->where('user_id', auth()->id())->sum('jumlah');
  $sisa_saldo = $simpan - $tarik;
@endphp

<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Form Edit Simpanan</h4>
        <form method="POST" action="{{ route('simpanan.update', $simpanan->id) }}" enctype="multipart/form-data" id="formSimpanan">
          @csrf
          @method('PATCH')

          <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip', $simpanan->nip) }}" required>
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $simpanan->alamat) }}</textarea>
          </div>

          <div class="form-group">
            <label for="no_hp">Nomor HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $simpanan->no_hp) }}" required>
          </div>

          <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" id="status" required onchange="toggleFormFields()">
                <option value="simpan" {{ $simpanan->status == 'simpan' ? 'selected' : '' }}>Simpan</option>
                <option value="tarik" {{ $simpanan->status == 'tarik' ? 'selected' : '' }}>Tarik</option>
            </select>
          </div>

          <!-- Inputan No Rekening (hanya muncul jika status 'tarik') -->
          <div class="form-group" id="no_rek_group" style="{{ $simpanan->status == 'tarik' ? 'display:block;' : 'display:none;' }}">
            <label for="no_rek">Nomor Rekening</label>
            <input type="text" name="no_rek" class="form-control" value="{{ old('no_rek', $simpanan->no_rek) }}">
          </div>

          <!-- Jumlah Simpanan atau Tarik -->
          <div class="form-group">
            <label for="jumlah" id="jumlah_label">{{ $simpanan->status == 'tarik' ? 'Jumlah Tarik (Rp)' : 'Jumlah Simpanan (Rp)' }}</label>
            <input type="number" name="jumlah" class="form-control" id="jumlah_input" value="{{ old('jumlah', $simpanan->jumlah) }}" placeholder="Contoh: 1000000" required min="1">
            <small id="saldo_warning" style="display:none;color:red;">Jumlah penarikan melebihi saldo Anda.</small>
          </div>

          <!-- Saldo jika status tarik -->
          <div class="form-group" id="saldo_info" style="{{ $simpanan->status == 'tarik' ? 'display:block;' : 'display:none;' }}">
            <label for="saldo">Saldo Anda</label>
            <p id="saldo_text" class="form-control-static">Rp {{ number_format($sisa_saldo, 0, ',', '.') }}</p>
            <small>Limit penarikan: Rp {{ number_format($sisa_saldo, 0, ',', '.') }}</small>
          </div>

          <!-- Bukti Transfer (hilang jika status tarik) -->
          <div class="form-group" id="bukti_tf_group" style="{{ $simpanan->status == 'tarik' ? 'display:none;' : 'display:block;' }}">
            <label for="bukti_tf">Bukti Transfer (Opsional)</label>
            <input type="file" name="bukti_tf" class="form-control" accept="image/*">
          </div>

          <button type="submit" class="btn btn-primary mr-2">Update</button>
          <a href="{{ route('simpanan.index') }}" class="btn btn-light">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleFormFields() {
    var status = document.getElementById('status').value;
    var noRekGroup = document.getElementById('no_rek_group');
    var saldoInfo = document.getElementById('saldo_info');
    var jumlahInput = document.getElementById('jumlah_input');
    var buktiTfGroup = document.getElementById('bukti_tf_group');
    var jumlahLabel = document.getElementById('jumlah_label');

    if (status === 'tarik') {
      noRekGroup.style.display = 'block';
      saldoInfo.style.display = 'block';
      buktiTfGroup.style.display = 'none';
      jumlahLabel.textContent = 'Jumlah Tarik (Rp)';
    } else {
      noRekGroup.style.display = 'none';
      saldoInfo.style.display = 'none';
      buktiTfGroup.style.display = 'block';
      jumlahLabel.textContent = 'Jumlah Simpanan (Rp)';
    }

    document.getElementById('saldo_warning').style.display = 'none';
  }

  document.getElementById('formSimpanan').addEventListener('submit', function(e) {
    var status = document.getElementById('status').value;
    var jumlah = parseInt(document.getElementById('jumlah_input').value);
    var sisaSaldo = {{ $sisa_saldo }};
    var warning = document.getElementById('saldo_warning');

    if (status === 'tarik' && jumlah > sisaSaldo) {
      e.preventDefault();
      warning.style.display = 'block';
    } else {
      warning.style.display = 'none';
    }
  });

  window.onload = toggleFormFields;
</script>
@endsection
