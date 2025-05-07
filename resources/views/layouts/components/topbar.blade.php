<div class="container-fluid bg-primary text-white d-none d-lg-flex wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-3">
        <div class="d-flex align-items-center">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/Logo_Full.png') }}" alt="" width="100px" height="auto">
            </a>
            <div class="ms-auto d-flex align-items-center">
                <small class="ms-4"><i class="fa fa-map-marker-alt me-3"></i>Nama Alamat Lengkap</small>
                <small class="ms-4"><i class="fa fa-envelope me-3"></i>Nama Email Lengkap</small>
                <small class="ms-4"><i class="fa fa-phone-alt me-3"></i>Nomor Telepon</small>
                @guest
                    <!-- Untuk pengguna yang belum login -->
                    <div class="ms-5 d-flex">
                        <a href="{{ route('login') }}" class="text-white text-decoration-none mx-4 hover-underline">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="text-white text-decoration-none hover-underline">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </a>
                    </div>
                @else
                    <!-- Untuk pengguna yang sudah login -->
                    <div class="ms-5 d-flex">
                        <a href="{{ route('home') }}" class="text-white text-decoration-none mx-4 hover-underline">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                        <a href="{{ route('logout') }}" class="text-white text-decoration-none hover-underline"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
