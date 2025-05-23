<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Keanggotaan & Mitra Kerjasama</title>
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

    <div class="container-fluid pt-6 pb-6">
        <div class="container">
            <div class="row g-5 mb-6">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-6 text-uppercase mb-4">Keanggotaan</h1>
                    <p class="mb-4">KSP IKR sebagai Primer Koperasi Nasional beranggotakan Pegawai/Karyawan/Anggota
                        Kopkar/Anggota Kopeg pada Institusi Mitra Kerjasama.</p>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 text-uppercase mb-4">Mitra Kerjasama</h1>
                    <p class="mb-4">Institusi Mitra Kerjasama Koperasi meliputi :
                        - Institusi Pemerintah (Kementerian, Lembaga, Badan, BUMN, BUMD, Pemprov, Pemkab & Pemko)
                        - Institusi Swasta (PT, CV & Yayasan)
                        - Kopkar/Kopeg.</p>
                </div>
            </div>

            <div class="row g-5 mt-6 text-center">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-6 text-uppercase mb-4">Mitra Kerjasama</h1>
                    <div class="row g-5">
                        <div class="col-4">
                            <img class="img-fluid" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                        </div>
                    </div>
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
