<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Event & Media Koperasi</title>
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

    <!-- Struktur Organisasi Start -->
    <div class="container-fluid service pt-6 pb-6" id="strukturOrganisasi">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="display-6 text-uppercase mb-5">Event & Media Seputar Koperasi</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}" alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Nama Event</h4>
                                    <p>deskripsi singkat</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}" alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Nama Event</h4>
                                    <p>deskripsi singkat</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}" alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Nama Event</h4>
                                    <p>deskripsi singkat</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}" alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Nama Event</h4>
                                    <p>deskripsi singkat</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}" alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Nama Event</h4>
                                    <p>deskripsi singkat</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}" alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Nama Event</h4>
                                    <p>deskripsi singkat</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}" alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Nama Event</h4>
                                    <p>deskripsi singkat</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}" alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Nama Event</h4>
                                    <p>deskripsi singkat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Struktur Organisasi End -->

    @include('layouts.components.footerDashboard')
    @include('layouts.components.copyright')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    @include('layouts.components.jsDashboard')
</body>

</html>
