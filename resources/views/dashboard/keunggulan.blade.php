<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Keunggulan Kami</title>
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

    <h1 class="display-6 text-uppercase text-center mt-5">Keunggulan Kompetitif</h1>
    <div class="container-fluid pt-6 pb-6">
        <div class="container">
            <div class="row g-5 mb-6">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                    <div class="about-img">
                        <img class="img-fluid w-100" src="{{ asset('assets/keunggulan.jpg') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="display-6 text-uppercase text-center">Keuntungan Bagi Anggota Koperasi</h1>
    <div class="container-fluid pt-3">
        <div class="container">
            <div class="row g-5 mb-6">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Akses Mudah dan Cepat ke Pinjaman: Manajemen
                        dan Karyawan Mitra Kerjasama dapat dengan mudah dan cepat mengajukan Pinjaman melalui ponsel
                        tanpa melalui proses yang rumit.
                        .</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Besaran Administrasi Pinjaman yang rendah:
                        KSP IKR menerapkan besaran Administrasi Pinjaman hanya 2 % per bulan (jauh lebih rendah
                        dibandingkan dengan Pinjaman Online/Pinjol), sehingga mengurangi beban finansial Manajemen dan
                        Karyawan Mitra Kerjasama.
                        .</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Tanpa SLIK OJK Checking: Manajemen dan
                        Karyawan Mitra Kerjasama dapat mengajukan Pinjaman tanpa harus melalui pemeriksaan Pinjaman yang
                        ketat seperti SLIK OJK Checking yang sering menjadi hambatan bagi banyak orang.
                        .</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Tanpa Agunan : Manajemen dan Karyawan Mitra
                        Kerjasama dapat mengajukan Pinjaman tanpa harus menyediakan Agunan berupa Aset (SHM/SHGB/BPKB)
                        dan/atau SK Karyawan
                        .</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Pembagian Sisa Hasil Usaha (SHU): Manajemen
                        dan Karyawan Mitra Kerjasama yang menjadi Anggota KSP IKR mendapatkan bagian dari Sisa Hasil
                        Usaha (SHU) yang dibagikan secara bulanan dan tahunan sehingga akan menambah pendapatan.
                        .</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Bagi Hasil dari Dana Simpanan: Manajemen dan
                        Karyawan Mitra Kerjasama dapat menyimpan dana pada KSP IKR berupa Simpanan Sukarela (Tabungan
                        Koperasi) dimana mendapatkan bagi hasil sebesar 9 % per tahun jika dana tersebut disalurkan ke
                        Pinjaman Anggota.
                        .</p>
                    <p class="text-justify"><i class="fa fa-check-square text-primary me-3"></i>Meningkatkan Kebiasaan Menabung: Menjadi
                        Anggota KSP IKR mendorong Manajemen dan Karyawan Mitra Kerjasama untuk menabung secara rutin
                        sehingga sangat membantu dalam hal perencanaan keuangan jangka panjang dan menghadapi keadaan
                        darurat dengan lebih baik.
                        .</p>
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
