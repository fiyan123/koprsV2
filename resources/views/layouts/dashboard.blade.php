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
    {{-- @include('layouts.components.carousel') --}}
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
                    <p class="mb-4">Koperasi merupakan singkatan dari Koperasi Simpan Pinjam Inklusi Keuangan Rakyat
                        yang merupakan Primer Koperasi Nasional yang bergerak di bidang Simpan Pinjam pada segmen mikro
                        dan ultra mikro.

                        Koperasi didirikan pada akhir tahun 2020 yang hadir sebagai Koperasi Modern “ Koperasi Digital ”
                        di Era Revolusi Industri 4.0 yang terdaftar dan diawasi oleh Kemenkop & UKM RI.</p>
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
                    <p class="mb-4">Salam sejahtera buat para stakeholder Koperasi baik Pengurus, Pengawas, Pengelola,
                        Anggota dan Calon Anggota, Kemenkop & UKM RI, para mitra Koperasi baik institusi Pemerintah
                        maupun Swasta termasuk Koperasi Primer dan Koperasi Sekunder dimanapun berada.

                        Pertama kita tidak lupa-lupanya memanjatkan puji syukur kepada Tuhan yang maha kuasa karena
                        dengan rahmat dan karunia Nya kita semua berada dalam keadaan sehat walafiat dan segala
                        aktivitas kita menjadi lancar dan sukses, Aamiin...

                        Para stakeholder Koperasi yang kami banggakan,

                        Pada kesempatan ini perlu kami sampaikan bahwa Koperasi ini hadir di saat pandemi Covid 19 yakni
                        pada akhir tahun 2020 yang lalu dan sebagaimana kita ketahui bahwa pemerintah kita pada waktu
                        itu tengah melakukan exit strategy agar pandemi Covid 19 tidak berdampak semakin dalam terhadap
                        perekonomian nasional dimana salah satu exit strategy adalah dengan melakukan percepatan
                        digitalisasi pada semua sektor perekonomian termasuk digitalisasi pada sektor perkoperasian dan
                        berdasarkan hal itulah Koperasi ini kami hadirkan dalam bentuk Koperasi Platform sebagai
                        Koperasi
                        Digital.

                        Kemudian hadirnya Koperasi sebagai Koperasi Digital tidak hanya mendukung pemerintah dalam
                        rangka
                        Digitalisasi Koperasi namun hadirnya Koperasi merupakan Gerakan Ekonomi Rakyat yang sangat
                        sesuai
                        dengan Pasal 33 UUD 1945 yang mana diharapkan juga memiliki andil dalam rangka memperkokoh
                        ketahanan perekonomian nasional yakni melalui inklusi keuangan yang lebih inklusif pada sektor
                        perkoperasian khususnya pada segmen mikro dan ultra mikro sehingga hadirnya Koperasi bisa
                        menyasar masyarakat secara lebih luas dengan memberikan manfaat yang optimal terutama terhadap
                        segmen mikro dan ultra mikro.

                        Akhir kata, kedepannya kita optimis Koperasi ini dapat menjadi wadah yang tepat bagi setiap
                        stakeholders untuk berhimpun dalam mewujudkan Gerakan Ekonomi Rakyat yang dilandasi semangat
                        gotong royong dan kekeluargaan serta nilai-nilai untuk saling memberdayakan sehingga Koperasi
                        nyata hadirnya sebagai salah satu Soko Guru perekonomian nasional dan tentu kontribusi Koperasi
                        terhadap PDB secara nasional pun akan menjadi signifikan dimasa yang akan datang. “ semoga “</p>
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
                    <p class="mb-4">Membangun & mengembangkan potensi & kemampuan ekonomi anggota khususnya &
                        masyarakat pada umumnya untuk meningkatkan kesejahteraan ekonomi & sosial.
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Secara aktif dalam upaya mempertinggi
                        kualitas kehidupan manusia & masyarakat
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Memperkokoh perekonomian rakyat sebagai dasar
                        kekuatan ketahanan Perekonomian Nasional & Koperasi sebagai soko gurunya
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Berusaha untuk memajukan & mengembangkan
                        perekonomian nasional yang merupakan usaha bersama berdasarkan azas kekeluargaan & demokrasi
                        ekonomi
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
                            <h5 class="text-uppercase mb-3">Gerakan Koperasi</h5>
                            <p>Koperasi merupakan salah satu tulang punggung Gerakan Koperasi di Indonesia yang memiliki
                                peran ikut menjaga eksistensi Koperasi di era Revolusi Industri 4.0.</p>
                            <a class="position-relative text-body text-uppercase small d-flex justify-content-between"
                                href="#"><b class="bg-white pe-3">Baca Lainnya</b> <i
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
                            <h5 class="text-uppercase mb-3">Gotong Royong</h5>
                            <p>Koperasi dengan semangat Gotong Royong ikut berperan dalam mewujudkan kesejahteraan
                                masyarakat Indonesia.</p>
                            <a class="position-relative text-body text-uppercase small d-flex justify-content-between"
                                href="#"><b class="bg-white pe-3">Baca Lainnya </b><i
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
                            <h5 class="text-uppercase mb-3">Gerakan Ekonomi Masyarakat</h5>
                            <p>Koperasi merupakan Gerakan Ekonomi Rakyat yang menjunjung tinggi jati diri Koperasi
                                berdasarkan nilai-nilai dan prinsip Koperasi.</p>
                            <a class="position-relative text-body text-uppercase small d-flex justify-content-between"
                                href="#"><b class="bg-white pe-3">Baca Lainnya</b> <i
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
                            <h5 class="text-uppercase mb-3">Inklusi Keuangan</h5>
                            <p>memiliki andil dalam mendorong Inklusi Keuangan dalam rangka memperkokoh
                                ketahanan perekonomian nasional.</p>
                            <a class="position-relative text-body text-uppercase small d-flex justify-content-between"
                                href="#"><b class="bg-white pe-3">Baca lainnya</b> <i
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
                    <p><i class="fa fa-check-square text-primary me-3"></i>Melakukan Literasi dan Edukasi tentang
                        Perkoperasian, Koperasi Digital dan Inklusi Keuangan.</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Melakukan Kerjasama dengan Institusi
                        Pemerintah, Institusi Swasta dan Kopkar/Kopeg sebagai Mitra Kerjasama Koperasi dalam rangka
                        Inklusi Keuangan Koperasi berupa Layanan Simpan Pinjam Koperasi DigitaI Koperasi untuk
                        Pegawai/Karyawan/Anggota Kopkar/Anggota Kopeg pada Mitra Kerjasama.</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Melakukan kerjasama dengan stakeholders
                        terkait yakni dengan Pemerintah melalui Kementerian/Lembaga terkait, pihak perbankan/lembaga
                        keuangan lainnya maupun dengan lembaga terkait lainnya dalam rangka pengembangan usaha Koperasi.
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Sebagai Koperasi Digital maka Koperasi secara
                        terus menerus melakukan pengembangan fitur Digitalisasi dan layanan digital baik back end (Core
                        Cooperative System) maupun front end (Mobile Apps) sesuai perkembangan teknologi.
                    </p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Melakukan tata kelola Koperasi secara best
                        practice dengan mengacu kepada ketentuan perkoperasian di Indonesia dengan didukung oleh Sumber
                        Daya Manusia (SDM) Koperasi yang kompeten, profesional dan berintegritas.
                        .</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Koperasi menjadi salah satu Inkubasi Centre
                        Koperasi Digital di Indonesia untuk segmen mikro dan ultra mikro.
                        .</p>
                    <p><i class="fa fa-check-square text-primary me-3"></i>Meningkatkan Kesejahteraan Anggota melalui
                        Bagi Hasil atas Pendapatan Administrasi Pinjaman yakni berupa SHU Bulanan Untuk Anggota Yang
                        Memiliki Pinjaman dan Cadangan SHU Tahunan Untuk Anggota (SHU Tahun Berjalan).
                        .</p>
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
                    <h1 class="display-6 text-uppercase text-white mb-4">Untuk Menjadi Anggota Koperasi</h1>
                    <div class="d-flex align-items-start wow fadeIn" data-wow-delay="0.5s">
                        <div class="btn-lg-square bg-white">
                            <i class="bi bi-geo-alt text-dark fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-white text-uppercase">Office Address</h6>
                            <span class="text-white">AXA Tower Lantai 45, Jl. Prof. Dr. Satrio Kav 18, Kuningan, Setiabudi, Jakarta Selatan 12940</span>
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
                        <h2 class="text-uppercase mb-4">Daftarkan Diri Anda</h2>
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
    {{-- @include('layouts.components.footerDashboard') --}}
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
