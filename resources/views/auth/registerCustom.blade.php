<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register | Koperasi</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assetsAdmin/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assetsAdmin/images/favicon.png') }}" />
</head>

<body>
    @include('sweetalert::alert')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-center py-5 px-4 px-sm-5">
                            <div class="brand-logo mb-3">
                                <img src="{{ asset('assets/Logo_Full.png') }}" alt="logo" class="img-fluid">
                            </div>
                            <h4>Baru Disini?</h4>
                            <h6 class="font-weight-light">Daftarkan Diri Anda Segera Disini.</h6>
                            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data"
                                class="pt-3">
                                @csrf

                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-lg"
                                        placeholder="Nama Lengkap" required>
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg"
                                        placeholder="Email" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="nip" class="form-control form-control-lg"
                                        placeholder="NIP (opsional)">
                                </div>

                                <div class="form-group">
                                    <textarea name="alamat" class="form-control form-control-lg" placeholder="Alamat Lengkap" rows="2"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="noktp" class="form-control form-control-lg"
                                        placeholder="No. KTP (opsional)">
                                </div>

                                <div class="form-group">
                                    <input type="date" name="tgl_lahir" class="form-control form-control-lg"
                                        placeholder="Tanggal Lahir">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="no_hp" class="form-control form-control-lg"
                                        placeholder="No. HP (opsional)">
                                </div>

                                {{-- <div class="form-group">
                                    <input type="file" name="foto" class="form-control form-control-lg"
                                        accept="image/*">
                                </div> --}}

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        placeholder="Password" required>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password_confirmation"
                                        class="form-control form-control-lg" placeholder="Konfirmasi Password" required>
                                </div>

                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        Daftar
                                    </button>
                                </div>

                                <div class="text-center mt-4 font-weight-light">
                                    Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('assetsAdmin/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assetsAdmin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/template.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/settings.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/todolist.js') }}"></script>
    <!-- endinject -->
</body>

</html>
