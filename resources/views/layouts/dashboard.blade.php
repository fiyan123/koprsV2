<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Koprs Simpan Pinjam</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    @include('layouts.components.cssDashboard')
</head>

<body>
    @include('sweetalert::alert')
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    @include('layouts.components.topbar')
    <!-- Topbar End -->

    <!-- Navbar Start -->
    @include('layouts.components.navbarDashboard')
    <!-- Navbar End -->

    <!-- Carousel Start -->
    @include('layouts.components.carousel')
    <!-- Carousel End -->

    <!-- About Start -->
    <div class="container-fluid pt-6 pb-6" id="tentang">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img">
                        <img class="img-fluid w-100" src="{{ asset('assets/i3.jpeg') }}">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 text-uppercase mb-4">Tentang Kami</h1>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tellus augue,
                        iaculis id elit eget, ultrices pulvinar tortor. Quisque vel lorem porttitor, malesuada arcu
                        quis, fringilla risus. Pellentesque eu consequat augue. Lorem ipsum dolor sit amet consectetur
                        adipisicing elit. Accusantium inventore similique laboriosam dignissimos quaerat necessitatibus
                        tenetur tempora assumenda consequatur molestias! Debitis sequi repudiandae suscipit blanditiis
                        iure dolorem est perferendis consectetur.</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Sambutan Start -->
    <div class="container-fluid pt-6 pb-6" id="sambutanKetua">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 text-uppercase mb-4 text-center">Sambutan Ketua</h1>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tellus augue,
                        iaculis id elit eget, ultrices pulvinar tortor. Quisque vel lorem porttitor, malesuada arcu
                        quis, fringilla risus. Pellentesque eu consequat augue. Lorem ipsum dolor sit amet consectetur
                        adipisicing elit. Accusantium inventore similique laboriosam dignissimos quaerat necessitatibus
                        tenetur tempora assumenda consequatur molestias! Debitis sequi repudiandae suscipit blanditiis
                        iure dolorem est perferendis consectetur.</p>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img">
                        <img class="img-fluid w-100" src="{{ asset('assets/visi-misi.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sambutan End -->

    <!-- Visi & Misi Start -->
    <div class="container-fluid pt-6 pb-6" id="visiMisi">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 text-uppercase mb-4">Visi & Misi</h1>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tellus augue,
                        iaculis id elit eget, ultrices pulvinar tortor. Quisque vel lorem porttitor, malesuada arcu
                        quis, fringilla risus. Pellentesque eu consequat augue. Lorem ipsum dolor sit amet consectetur
                        adipisicing elit. Accusantium inventore similique laboriosam dignissimos quaerat necessitatibus
                        tenetur tempora assumenda consequatur molestias! Debitis sequi repudiandae suscipit blanditiis
                        iure dolorem est perferendis consectetur.</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum
                    </p>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img">
                        <img class="img-fluid w-100" src="{{ asset('assets/visi-misi.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Visi & Misi End -->

    <!-- Core Values -->
    <div class="container-fluid pt-6 pb-6" id="coreValues">
        <div class="d-flex justify-content-center align-items-center">
            <h1 class="display-6 text-uppercase mb-4 text-center">Core Values</h1>
        </div>
        <div class="container pt-4">
            <div class="row g-0 feature-row wow fadeIn" data-wow-delay="0.1s">
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                    <div class="feature-item border h-100">
                        <div class="feature-icon btn-xxl-square bg-primary mb-4 mt-n4">
                            <i class="fa fa-hammer fa-2x text-white"></i>
                        </div>
                        <div class="p-5 pt-0">
                            <h5 class="text-uppercase mb-3">Nama Gerakan</h5>
                            <p>Detail Deskripsi Dari Gerakan.</p>
                            <a class="position-relative text-body text-uppercase small d-flex justify-content-between"
                                href="#"><b class="bg-white pe-3">Read More</b> <i
                                    class="bi bi-arrow-right bg-white ps-3"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.4s">
                    <div class="feature-item border h-100">
                        <div class="feature-icon btn-xxl-square bg-primary mb-4 mt-n4">
                            <i class="fa fa-dollar-sign fa-2x text-white"></i>
                        </div>
                        <div class="p-5 pt-0">
                            <h5 class="text-uppercase mb-3">Nama Gerakan</h5>
                            <p>Detail Deskripsi Dari Gerakan.</p>
                            <a class="position-relative text-body text-uppercase small d-flex justify-content-between"
                                href="#"><b class="bg-white pe-3">Read More</b> <i
                                    class="bi bi-arrow-right bg-white ps-3"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                    <div class="feature-item border h-100">
                        <div class="feature-icon btn-xxl-square bg-primary mb-4 mt-n4">
                            <i class="fa fa-check-double fa-2x text-white"></i>
                        </div>
                        <div class="p-5 pt-0">
                            <h5 class="text-uppercase mb-3">Nama Gerakan</h5>
                            <p>Detail Deskripsi Dari Gerakan.</p>
                            <a class="position-relative text-body text-uppercase small d-flex justify-content-between"
                                href="#"><b class="bg-white pe-3">Read More</b> <i
                                    class="bi bi-arrow-right bg-white ps-3"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.6s">
                    <div class="feature-item border h-100">
                        <div class="feature-icon btn-xxl-square bg-primary mb-4 mt-n4">
                            <i class="fa fa-tools fa-2x text-white"></i>
                        </div>
                        <div class="p-5 pt-0">
                            <h5 class="text-uppercase mb-3">Nama Gerakan</h5>
                            <p>Detail Deskripsi Dari Gerakan.</p>
                            <a class="position-relative text-body text-uppercase small d-flex justify-content-between"
                                href="#"><b class="bg-white pe-3">Read More</b> <i
                                    class="bi bi-arrow-right bg-white ps-3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Core Values End -->

    <!-- Struktur Organisasi Start -->
    <div class="container-fluid service pt-6 pb-6" id="strukturOrganisasi">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="display-6 text-uppercase mb-5">Struktur Organisasi</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Jabatan Organisasi</h4>
                                    <p>Nama Lengkap</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Jabatan Organisasi</h4>
                                    <p>Nama Lengkap</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Jabatan Organisasi</h4>
                                    <p>Nama Lengkap</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Jabatan Organisasi</h4>
                                    <p>Nama Lengkap</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Jabatan Organisasi</h4>
                                    <p>Nama Lengkap</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Jabatan Organisasi</h4>
                                    <p>Nama Lengkap</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Jabatan Organisasi</h4>
                                    <p>Nama Lengkap</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="service-item">
                        <div class="service-inner pb-5">
                            <img class="img-fluid w-100" src="{{ asset('assets/fungsi-koperasi-di-Indonesia.jpg') }}"
                                alt="">
                            <div class="service-text px-5 pt-4">
                                <h5 class="text-uppercase">Jabatan Organisasi</h4>
                                    <p>Nama Lengkap</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Struktur Organisasi End -->

    <!-- Program Kerja Start -->
    <div class="container-fluid team pt-6 pb-6" id="programKerja">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-12 text-uppercase mb-4 text-center">Program Kerja</h1>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tellus augue,
                        iaculis id elit eget, ultrices pulvinar tortor. Quisque vel lorem porttitor, malesuada arcu
                        quis, fringilla risus. Pellentesque eu consequat augue. Lorem ipsum dolor sit amet consectetur
                        adipisicing elit. Accusantium inventore similique laboriosam dignissimos quaerat necessitatibus
                        tenetur tempora assumenda consequatur molestias! Debitis sequi repudiandae suscipit blanditiis
                        iure dolorem est perferendis consectetur. Lorem ipsum dolor sit amet consectetur adipisicing
                        elit. Dignissimos, aperiam! Consequuntur perferendis vero cumque nobis minus natus explicabo eos
                        atque!</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Many variations of passages of lorem ipsum
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Program Kerja End -->

    <!-- Appoinment Start -->
    <div class="container-fluid appoinment mt-6 py-5 wow fadeIn" data-wow-delay="0.1s" id="hubungiKami">
        <div class="container pt-5">
            <div class="row gy-5 gx-0">
                <div class="col-lg-6 pe-lg-5 wow fadeIn" data-wow-delay="0.3s">
                    <h1 class="display-6 text-uppercase text-white mb-4">Saran Dan Masukkan Umum</h1>
                    <p class="text-white mb-5 wow fadeIn" data-wow-delay="0.4s">Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Curabitur tellus
                        augue, iaculis id elit eget, ultrices pulvinar tortor.</p>
                    <div class="d-flex align-items-start wow fadeIn" data-wow-delay="0.5s">
                        <div class="btn-lg-square bg-white">
                            <i class="bi bi-geo-alt text-dark fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-white text-uppercase">Office Address</h6>
                            <span class="text-white">123 Street, New York, USA</span>
                        </div>
                    </div>
                    <hr class="bg-body">
                    <div class="d-flex align-items-start wow fadeIn" data-wow-delay="0.6s">
                        <div class="btn-lg-square bg-white">
                            <i class="bi bi-clock text-dark fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-white text-uppercase">Office Time</h6>
                            <span class="text-white">Mon-Sat 09am-5pm, Sun Closed</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-n5 wow fadeIn" data-wow-delay="0.7s">
                    <div class="bg-white p-5">
                        <h2 class="text-uppercase mb-4">Daftar Diri Anda</h2>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0 bg-light" id="name"
                                        placeholder="Your Name">
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control border-0 bg-light" id="mail"
                                        placeholder="Your Email">
                                    <label for="mail">Your Email</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0 bg-light" id="mobile"
                                        placeholder="Your Mobile">
                                    <label for="mobile">Your Mobile</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <select class="form-select border-0 bg-light" id="service">
                                        <option selected>Steel Welding</option>
                                        <option value="">Pipe Welding</option>
                                    </select>
                                    <label for="service">Choose A Service</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control border-0 bg-light" placeholder="Leave a message here" id="message"
                                        style="height: 130px"></textarea>
                                    <label for="message">Message</label>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-primary w-100 py-3" type="submit">Submit Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Appoinment End -->

    <!-- Footer Start -->
    @include('layouts.components.footerDashboard')
    <!-- Footer End -->

    <!-- Copyright Start -->
    @include('layouts.components.copyright')
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries & Template-->
    @include('layouts.components.jsDashboard')
</body>

</html>
