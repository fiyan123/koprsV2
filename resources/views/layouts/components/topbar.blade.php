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
                <a href="{{ route('login') }}" class="ms-4 text-decoration-none text-dark">
                    <small><i class="fas fa-sign-in-alt me-2"></i> Login</small>
                </a>
            </div>
        </div>
    </div>
</div>
