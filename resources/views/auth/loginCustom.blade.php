<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | Koperasi</title>
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
    <link rel="shortcut icon" href="{{ asset('assets/Logo_New_Juwita.png') }}" />
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
                            <h4 class="mb-3">Selamat Datang</h4>
                            <h6 class="font-weight-light mb-3">Silahkan Login Untuk Melanjutkan.</h6>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter email address" value="{{ old('email') }}" required
                                        autocomplete="email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control pe-5" id="password-input" name="password"
                                        placeholder="Enter password" required autocomplete="current-password">
                                </div>
                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Masuk</button>
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
    <script src="{{ asset('assetsAdmin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/template.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/settings.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/todolist.js') }}"></script>
    <!-- endinject -->
</body>

</html>
