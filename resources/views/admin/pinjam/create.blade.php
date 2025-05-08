@extends('layouts.admin')

@section('title', 'Tambah Pinjaman')

@section('breadcrumb')
  <x-dashboard.breadcrumb title="Tambah Pinjaman" page="Dashboard" active="Tambah Pinjaman" route="{{ route('dashboard') }}" />
@endsection

@section('content')
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Form Tambah Pinjaman</h4>
        <form method="POST" action="{{ route('pinjaman.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label for="jumlah">Jumlah Pinjaman (Rp)</label>
            <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Misal: 1000000">
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
            <label for="durasi" id="durasi-label">Durasi (hari)</label>
            <input type="number" name="durasi" class="form-control" placeholder="Misal: 10" required>
          </div>
          <div class="form-group">
            <label for="no_rekening">Nomor Rekening Penerima</label>
            <input type="text" name="no_rekening" id="no_rekening" class="form-control" placeholder="Contoh: 1234567890" required>
          </div>
          <div class="form-group">
            <label for="tgl_lahir">Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" name="nip" id="nip" class="form-control" placeholder="Contoh: 1987654321" required>
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
          </div>

          <div class="form-group">
            <label for="no_ktp">Nomor KTP</label>
            <input type="text" name="no_ktp" id="no_ktp" class="form-control" placeholder="Contoh: 3201234567890001" required>
          </div>

          <div class="form-group">
            <label for="no_hp">Nomor HP</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="Contoh: 081234567890" required>
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

          <input type="hidden" name="bunga" id="bunga-hidden">

          <div class="form-group">
            <label>Simulasi Angsuran</label>
            <button type="button" class="btn btn-info btn-sm mb-2" onclick="hitungAngsuran()">Hitung</button>
            <div id="hasil-angsuran" class="border rounded p-3 bg-light"></div>
          </div>

          <button type="submit" class="btn btn-primary mr-2">Submit</button>
          <a href="{{ route('pinjaman.index') }}" class="btn btn-light">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    // Update label durasi berdasarkan tipe durasi
    function updateDurasiLabel() {
        var tipeDurasi = document.getElementById('tipe_durasi').value;
        var durasiLabel = document.getElementById('durasi-label');
        if (tipeDurasi === 'harian') {
            durasiLabel.textContent = 'Durasi (hari)';
        } else if (tipeDurasi === 'bulanan') {
            durasiLabel.textContent = 'Durasi (bulan)';
        } else if (tipeDurasi === 'tahunan') {
            durasiLabel.textContent = 'Durasi (tahun)';
        }
    }

    // Fungsi untuk menghitung angsuran
    function hitungAngsuran() {
        var jumlahPinjaman = parseInt(document.getElementById('jumlah').value);
        var tipeDurasi = document.getElementById('tipe_durasi').value;
        var durasi = parseInt(document.getElementsByName('durasi')[0].value);

        if (isNaN(jumlahPinjaman) || isNaN(durasi)) {
            alert('Harap masukkan jumlah pinjaman dan durasi dengan benar.');
            return;
        }

        // Tentukan bunga berdasarkan tipe durasi
        var bunga = 0;
        if (tipeDurasi === 'harian') {
            bunga = 1; // Bunga harian 1%
        } else if (tipeDurasi === 'bulanan') {
            bunga = 4; // Bunga bulanan 4%
        } else if (tipeDurasi === 'tahunan') {
            bunga = 8; // Bunga tahunan 8%
        }

        // Hitung total bunga berdasarkan tipe durasi
        var totalBunga = 0;

        if (tipeDurasi === 'harian') {
            // Bunga harian: 1% per hari
            totalBunga = (bunga / 100) * jumlahPinjaman * durasi;
        } else if (tipeDurasi === 'bulanan') {
            // Bunga bulanan: langsung dihitung seperti biasa
            totalBunga = (bunga / 100) * jumlahPinjaman * durasi;
        } else if (tipeDurasi === 'tahunan') {
            // Bunga tahunan: bunga per bulan dikali 12
            totalBunga = (bunga / 100) * jumlahPinjaman * durasi;
        }

        // Hitung total pembayaran
        var totalPembayaran = jumlahPinjaman + totalBunga;

        // Hitung cicilan per pembayaran
        var cicilanPerPembayaran = totalPembayaran / durasi;

        // Simpan bunga ke hidden field
        document.getElementById('bunga-hidden').value = bunga;

        // Tampilkan hasil
        var hasilAngsuran = `
            <strong>Rincian Pembayaran:</strong><br>
            Jumlah Pinjaman: Rp ${jumlahPinjaman.toLocaleString()}<br>
            Bunga (%): ${bunga}%<br>
            Total Bunga: Rp ${totalBunga.toLocaleString()}<br>
            Total Pembayaran (Pokok + Bunga): Rp ${totalPembayaran.toLocaleString()}<br>
            Cicilan per Pembayaran: Rp ${cicilanPerPembayaran.toLocaleString()}<br>
        `;
        document.getElementById('hasil-angsuran').innerHTML = hasilAngsuran;
    }
</script>
@endsection
