<div class="container-fluid bg-white sticky-top wow fadeIn bgGreen" data-wow-delay="0.1s">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-white navbar-light p-lg-0">
            <a href="{{ route('dashboard') }}" class="navbar-brand d-lg-none">
                <img src="{{ asset('assets/Logo_Full.png') }}" alt="" width="100px" height="auto">
            </a>
            <button type="button" class="navbar-toggler me-0" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarDashboard">
                <div class="navbar-nav">
                    <div class="nav-item dropdown">
                        <a href="{{ route('dashboard') }}" class="nav-link dropdown-toggle {{ Request::is('/*') ? 'active' : '' }}" data-bs-toggle="dropdown"
                            id="text-navbar">Tentang Kami</a>
                        <div class="dropdown-menu bg-light rounded-0 rounded-bottom m-0">
                            <a href="{{ url('/#sambutanKetua') }}" class="dropdown-item">Sambutan Ketua</a>
                            <a href="{{ url('/#visiMisi') }}" class="dropdown-item">Visi & Misi</a>
                            <a href="{{ url('/#coreValues') }}" class="dropdown-item">Values</a>
                            <a href="{{ url('/#strukturOrganisasi') }}" class="dropdown-item">Struktur Organisasi</a>
                            <a href="{{ url('/#programKerja') }}" class="dropdown-item">Program Kerja</a>
                            {{-- <a href="{{ url('/#hubungiKami') }}" class="dropdown-item">Hubungi Kami</a> --}}
                        </div>
                    </div>

                    <a href="{{ route('keanggotaan') }}" class="nav-item nav-link nav-dashboard {{ Request::is('keanggotaan') ? 'active' : '' }}"
                        id="text-navbar">Keanggotaan & Mitra Kerjasama
                    </a>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle nav-dashboard {{ Request::is('simpanPinjam*') ? 'active' : '' }}" data-bs-toggle="dropdown"
                            id="text-navbar">Produk</a>
                        <div class="dropdown-menu bg-light rounded-0 rounded-bottom m-0">
                            <a href="{{ url('/simpanPinjam#simpanan') }}" class="dropdown-item">Simpanan</a>
                            <a href="{{ url('/simpanPinjam#pinjaman') }}" class="dropdown-item">Pinjaman</a>
                        </div>
                    </div>

                    <a href="{{ route('keunggulan') }}" class="nav-item nav-link nav-dashboard {{ Request::is('keunggulan*') ? 'active' : '' }}" id="text-navbar">Keunggulan</a>
                    <a href="{{ route('eventMedia') }}" class="nav-item nav-link nav-dashboard {{ Request::is('eventMedia*') ? 'active' : '' }}" id="text-navbar">Event & Media</a>
                </div>

                <div class="ms-auto d-none d-lg-block">
                    <a href="" class="btn btn-primary py-2 px-3" id="text-navbar">+ 62093049329121</a>
                </div>
            </div>
        </nav>
    </div>
</div>
