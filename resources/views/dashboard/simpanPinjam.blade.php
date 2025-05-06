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
    @include('layouts.components.carousel')

    <h1 class="display-6 text-uppercase text-center">Ketentuan & Syarat Simpanan Koperasi</h1>
    <div class="container-fluid pt-6 pb-6">
        <div class="container">
            <div class="row g-5 mb-6" id="simpanan">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-6 text-uppercase mb-4">#Ketentuan Simpanan Pokok Anggota</h1>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
                </div>
            </div>
            <div class="row g-5 mb-6">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 text-uppercase mb-4">#Ketentuan Simpanan Wajib Anggota</h1>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
                </div>
            </div>
            <div class="row g-5 mb-6">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 text-uppercase mb-4">#Ketentuan Simpanan Sukarela</h1>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
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
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum</p>
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
