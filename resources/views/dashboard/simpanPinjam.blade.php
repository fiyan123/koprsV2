<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Simpanan & Pinjamanan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    @include('layouts.components.cssDashboard')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    @include('layouts.components.topbar')
    @include('layouts.components.navbarDashboard')
    {{-- @include('layouts.components.carousel') --}}

    <h1 class="display-6 text-uppercase text-center mt-5">Ketentuan & Syarat Simpanan Koperasi</h1>
    <div class="container-fluid pt-6 pb-6">
        <div class="container">
            <div class="row g-5 mb-6" id="simpanan">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-6 text-uppercase mb-4">#Ketentuan Simpanan Pokok Anggota</h1>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Besaran Simpanan Pokok
                        Rp. 25.000,- .</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Pokok
                        disetorkan secara kolektif ke
                        Rekening Koperasi oleh PIC Mitra Kerjasama Koperasi berdasarkan Surat Pemberitahuan Tagihan
                        Koperasi.</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Pokok dapat
                        dilihat secara real time
                        melalui web browser pada Akses Layanan Koperasi dari ponsel Anggota.</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Pokok merupakan
                        komponen Ekuitas
                        Koperasi pada Neraca Koperasi.</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Atas Simpanan Pokok
                        mendapatkan Sisa Hasil
                        Usaha (SHU) Tahunan secara proporsional yang dialokasikan dari Cadangan SHU Tahunan Untuk
                        Anggota sebagaimana mengacu kepada Ketentuan Alokasi Bagi Hasil Pendapatan Administrasi Pinjaman
                        Koperasi.</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Jika Dana Simpanan Pokok
                        disalurkan ke
                        Pinjaman Anggota maka akan mendapatkan Bagi Hasil setiap bulannya sesuai jangka waktu Pinjaman
                        dengan besaran Bagi Hasil atas Simpanan Pokok sebesar 37,5 % dari Besaran Administrasi Pinjaman
                        Per Bulan.</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Pokok tidak
                        dikenakan biaya
                        administrasi bulanan.</p>
                </div>
            </div>
            <div class="row g-5 mb-6">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 text-uppercase mb-4">#Ketentuan Simpanan Wajib Anggota</h1>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Besaran Simpanan Wajib
                        Rp. 35.000,- per
                        bulan. </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Wajib
                        disetorkan secara kolektif ke
                        Rekening Koperasi oleh PIC Mitra Kerjasama Koperasi berdasarkan Surat Pemberitahuan Tagihan
                        Koperasi.
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Wajib dapat
                        dilihat secara real time
                        melalui web browser pada Akses Layanan Koperasi dari ponsel Anggota.
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Wajib merupakan
                        komponen Ekuitas
                        Koperasi pada Neraca Koperasi.
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Atas Simpanan Wajib
                        mendapatkan Sisa Hasil
                        Usaha (SHU) Tahunan secara proporsional yang dialokasikan dari Cadangan SHU Tahunan Untuk
                        Anggota sebagaimana mengacu kepada Ketentuan Alokasi Bagi Hasil Pendapatan Administrasi Pinjaman
                        Koperasi.
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Jika Dana Simpanan Wajib
                        disalurkan ke
                        Pinjaman Anggota maka akan mendapatkan Bagi Hasil setiap bulannya sesuai jangka waktu Pinjaman
                        dengan besaran Bagi Hasil atas Simpanan Wajib sebesar 37,5 % dari Besaran Administrasi Pinjaman
                        Per Bulan.
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Wajib tidak
                        dikenakan biaya
                        administrasi bulanan.
                    </p>
                </div>
            </div>
            <div class="row g-5 mb-6">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 text-uppercase mb-4">#Ketentuan Simpanan Sukarela</h1>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Tidak ada ketentuan
                        minimal dan maksimal atas
                        setoran Simpanan Sukarela (Tabungan Koperasi) namun kegiatan penghimpunan Dana Simpanan Sukarela
                        (Tabungan Koperasi) dilakukan berdasarkan Keseimbangan Dana yakni Keseimbangan antara Dana yang
                        dihimpun dengan Volume Pinjaman yang akan disalurkan ke Anggota.

                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Penyetoran Simpanan
                        Sukarela (Tabungan
                        Koperasi) dapat dilakukan kapan saja.
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Sukarela
                        (Tabungan Koperasi) dapat
                        dilihat secara real time melalui web browser pada Akses Layanan Koperasi dari ponsel Anggota.

                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Sukarela
                        (Tabungan Koperasi)
                        merupakan komponen Kewajiban Koperasi pada Neraca Koperasi.

                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Alur Proses Transaksi
                        Penempatan Dana
                        Simpanan Sukarela (Tabungan Koperasi) oleh Anggota sebagai berikut : <br>
                        1. Anggota Koperasi melakukan penyetoran Dana Simpanan Sukarela (Tabungan Koperasi) ke Dompet
                        Simpanan Sukarela (Tabungan Koperasi) melalui Transfer ke Nomor Virtual Account (VA) Dompet
                        Simpanan Sukarela Anggota pada Koperasi. <br>
                        2. Khusus untuk Penempatan Dana Simpanan Sukarela (Tabungan Koperasi) oleh Anggota yang
                        disalurkan
                        ke Pinjaman Karyawan maka Anggota dan Koperasi menandatangani Perjanjian Penempatan Dana
                        Simpanan
                        Sukarela (Tabungan Koperasi) dengan bermaterai cukup. <br>
                        3. Jumlah Nominal Penempatan Dana Simpanan Sukarela (Tabungan Koperasi) dicatat pada Buku
                        Simpanan
                        Sukarela (Tabungan Koperasi) Koperasi.

                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Atas Dana Simpanan
                        Sukarela (Tabungan
                        Koperasi) yang disalurkan ke Pinjaman Anggota maka akan mendapatkan Bagi Hasil setiap bulannya
                        sesuai jangka waktu Pinjaman dengan besaran Bagi Hasil atas Dana Simpanan Sukarela (Tabungan
                        Koperasi) sebesar 37,5 % dari Besaran Administrasi Pinjaman Per Bulan.

                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i> Atas penempatan Dana
                        Simpanan Sukarela
                        (Tabungan Koperasi) Anggota yang dananya tidak tersalurkan ke Pinjaman Anggota maka sebesar
                        saldo dana yang tidak tersalurkan ke Pinjaman Anggota akan mendapatkan bunga bulanan yang
                        besarannya sesuai ketentuan bunga simpanan pada Bank.

                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Simpanan Sukarela
                        (Tabungan Koperasi) tidak
                        dikenakan biaya administrasi bulanan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h1 class="display-6 text-uppercase text-center">Ketentuan & Syarat Pinjaman Koperasi</h1>
    <div class="container-fluid pt-6" id="pinjaman">
        <div class="container">
            <div class="row g-5 mb-6">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-6 text-uppercase mb-4">#Ketentuan Pinjaman Anggota</h1>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Jenis Pinjaman :
                        1. Pinjaman Konsumtif
                        2. Pinjaman Investasi
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Besaran Administrasi Pinjaman : 2 % per bulan
                        (flat rate)
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Jangka Waktu Pinjaman : 1 bulan s/d 12 bulan
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i> Plafond Pinjaman maksimal :
                        1. Manajemen & Karyawan Tetap (PKWTT) :
                        Plafond Maksimal : 150% dari Gaji Bulanan (Take Home Pay/THP)
                        Jangka Waktu Maksimal : 12 Bulan
                        2. Manajemen & Karyawan Kontrak (Kontrak langsung dengan Mitra Kerjasama KSP IKR) dengan Kontrak
                        PKWT
                        Minimal 12 Bulan :
                        Plafond Maksimal : 100% dari Gaji Bulanan (Take Home Pay/THP)
                        Jangka Waktu Maksimal : sesuai sisa bulan berjalan Kontrak PKWT
                        3. Karyawan Outsourcing
                        Plafond Maksimal : 50 % dari Gaji Berjalan
                        Jangka Waktu Maksimal : 1 Bulan
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Limit Pinjaman Instant maksimal : Rp.
                        500.000,- (Lima Ratus Ribu Rupiah)
                    </p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Tanggal Jatuh Tempo Pembayaran Angsuran
                        Pinjaman adalah setiap tanggal pembayaran gaji (payroll) Manajemen & Karyawan pada setiap
                        entitas Mitra Kerjasama KSP IKR.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.components.footerDashboard')
    @include('layouts.components.copyright')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    @include('layouts.components.jsDashboard')
</body>

</html>
