<div class="container-fluid bg-white sticky-top wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-white navbar-light p-lg-0">
            <a href="{{ route('dashboard') }}" class="navbar-brand d-lg-none">
                <img src="{{ asset('assets/Logo-Koperasi.png') }}" alt="" width="80px">
            </a>
            <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="{{ route('dashboard') }}" class="nav-item nav-link nav-dashboard {{ Request::is('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>

                    <div class="nav-item dropdown">
                        <a href="#tentang" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                            id="text-navbar">Tentang Kami</a>
                        <div class="dropdown-menu bg-light rounded-0 rounded-bottom m-0">
                            <a href="{{ url('/dashboard#sambutanKetua') }}" class="dropdown-item">Sambutan Ketua</a>
                            <a href="{{ url('/dashboard#visiMisi') }}" class="dropdown-item">Visi & Misi</a>
                            <a href="{{ url('/dashboard#coreValues') }}" class="dropdown-item">Values</a>
                            <a href="{{ url('/dashboard#strukturOrganisasi') }}" class="dropdown-item">Struktur Organisasi</a>
                            <a href="{{ url('/dashboard#programKerja') }}" class="dropdown-item">Program Kerja</a>
                            <a href="{{ url('/dashboard#hubungiKami') }}" class="dropdown-item">Hubungi Kami</a>
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
