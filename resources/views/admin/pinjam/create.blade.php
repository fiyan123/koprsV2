@extends('layouts.admin')
@section('content')

<div class="main-panel">
  <div class="content-wrapper">

    <div class="row mb-3">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h4 class="card-title">Create Pinjaman</h4>
              <a href="{{ route('dashboard') }}">Dashboard / Pinjaman / Create</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Form Pinjaman</h4>
            <form method="POST" action="#">
              @csrf
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
              </div>
              <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" name="nip" class="form-control" placeholder="NIP" maxlength="20" required>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap" required></textarea>
              </div>
              <div class="form-group">
                <label for="jumlah">Jumlah Pinjaman (Rp)</label>
                <input type="number" step="0.01" name="jumlah" class="form-control" placeholder="Misal: 5000000" required>
              </div>
              <div class="form-group">
                <label for="tipe_durasi">Tipe Durasi</label>
                <select name="tipe_durasi" class="form-control" id="tipe_durasi" onchange="updateDurasiLabel()">
                  <option value="harian">Harian</option>
                  <option value="bulanan" selected>Bulanan</option>
                  <option value="tahunan">Tahunan</option>
                </select>
              </div>
              <div class="form-group">
                <label for="durasi" id="durasi-label">Durasi (bulan)</label>
                <input type="number" name="durasi" class="form-control" placeholder="Misal: 12" required>
              </div>

              <input type="hidden" name="bunga" id="bunga-hidden">

              <div class="form-group">
                <label for="no_rek">No Rekening</label>
                <input type="text" name="no_rek" class="form-control" placeholder="Nomor Rekening" required>
              </div>

              <div class="form-group">
                <label>Simulasi Angsuran</label>
                <button type="button" class="btn btn-sm btn-info mb-2" onclick="hitungAngsuran()">Hitung</button>
                <div id="hasil-angsuran" class="border rounded p-3 bg-light"></div>
              </div>

              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="pending">Pending</option>
                  <option value="approved">Approved</option>
                  <option value="rejected">Rejected</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary mr-2">Submit</button>
              <a href="{{ route('Pinjam.index') }}" class="btn btn-light">Cancel</a>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  function updateDurasiLabel() {
    const tipe = document.getElementById("tipe_durasi").value;
    const label = document.getElementById("durasi-label");
    if (tipe === 'harian') label.innerText = "Durasi (hari)";
    else if (tipe === 'tahunan') label.innerText = "Durasi (tahun)";
    else label.innerText = "Durasi (bulan)";
  }

  function getBungaByJumlah(jumlah, isLangsung = false) {
    if (jumlah < 1000000) return isLangsung ? 0.6 : 1.6; // 0.6% untuk pelunasan langsung, 1.6% untuk cicilan
    if (jumlah >= 1000000 && jumlah < 10000000) return isLangsung ? 0.5 : 1.5; // 0.5% untuk pelunasan langsung, 1.5% untuk cicilan
    if (jumlah >= 10000000 && jumlah < 25000000) return isLangsung ? 0.4 : 1.4; // 0.4% untuk pelunasan langsung, 1.4% untuk cicilan
    if (jumlah >= 25000000 && jumlah <= 50000000) return isLangsung ? 0.3 : 1.3; // 0.3% untuk pelunasan langsung, 1.3% untuk cicilan
    return isLangsung ? 0.2 : 1.2; // > 50 juta
  }

  function hitungAngsuran() {
    const jumlah = parseFloat(document.querySelector('[name="jumlah"]').value);
    const durasi = parseInt(document.querySelector('[name="durasi"]').value);
    const tipe = document.getElementById("tipe_durasi").value;

    if (!jumlah || !durasi || isNaN(jumlah) || isNaN(durasi)) {
      alert("Mohon isi jumlah dan durasi dengan benar!");
      return;
    }

    let durasiBulan;
    if (tipe === 'harian') durasiBulan = durasi; // Harian dihitung langsung tanpa konversi
    else if (tipe === 'tahunan') durasiBulan = durasi * 12; // 1 tahun = 12 bulan
    else durasiBulan = durasi; // Bulanan tetap durasi dalam bulan

    const bungaCicilan = getBungaByJumlah(jumlah, false);
    const bungaPerBulanCicilan = bungaCicilan / 100;

    const bungaLunas = getBungaByJumlah(jumlah, true);
    const bungaPerBulanLunas = bungaLunas / 100;

    const pokokPerPeriode = jumlah / durasiBulan;
    const bungaPerPeriode = jumlah * bungaPerBulanCicilan / durasiBulan;
    const angsuranPerPeriode = pokokPerPeriode + bungaPerPeriode;
    const totalCicilan = angsuranPerPeriode * durasiBulan;

    const totalLunas = jumlah + (jumlah * bungaPerBulanLunas);

    document.getElementById('bunga-hidden').value = bungaCicilan.toFixed(2);

    let hasil = `
      <strong>Simulasi Pinjaman</strong><br><br>
      <ul>
        <li><strong>Jumlah Pinjaman:</strong> Rp ${jumlah.toLocaleString('id-ID')}</li>
        <li><strong>Durasi:</strong> ${durasi} ${tipe}</li>
        <li><strong>Bunga Cicilan:</strong> ${bungaCicilan.toFixed(2)}% per periode</li>
        <li><strong>Total Bunga Cicilan:</strong> ${bungaCicilan * durasi}%</li>
        <li><strong>Angsuran per periode:</strong> Rp ${angsuranPerPeriode.toFixed(2).toLocaleString('id-ID')}</li>
        <li><strong>Total pembayaran cicilan:</strong> Rp ${totalCicilan.toFixed(2).toLocaleString('id-ID')}</li>
        <li><strong>Total pelunasan langsung:</strong> <span class="text-success">Rp ${totalLunas.toFixed(2).toLocaleString('id-ID')}</span></li>
      </ul>
    `;

    document.getElementById('hasil-angsuran').innerHTML = hasil;
  }
</script>

@endsection
