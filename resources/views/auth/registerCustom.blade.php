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
    <style>
        .text-start {
            text-align: left;
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light py-5 px-4 px-sm-5">
                            <div class="brand-logo mb-3 text-center">
                                <img src="{{ asset('assets/Logo_Full.png') }}" alt="logo" class="img-fluid">
                            </div>
                            <h4>Baru Disini?</h4>
                            <h6 class="font-weight-light">Daftarkan Diri Anda Segera Disini.</h6>
                            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data"
                                class="pt-3">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="form-label text-start">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control form-control-lg"
                                        placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label text-start">Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg"
                                        placeholder="Email" value="{{ old('email') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="nip" class="form-label text-start">NIP</label>
                                    <input type="text" name="nip" class="form-control form-control-lg"
                                        placeholder="NIP" value="{{ old('nip') }}">
                                </div>

                                <div class="form-group">
                                    <label for="alamat" class="form-label text-start">Alamat</label>
                                    <textarea name="alamat" value="{{ old('alamat') }}" class="form-control form-control-lg" placeholder="Alamat Lengkap" rows="2"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="no_ktp" class="form-label text-start">Nomor KTP</label>
                                    <input type="text" name="no_ktp" class="form-control form-control-lg"
                                        placeholder="No. KTP" value="{{ old('no_ktp') }}">
                                </div>

                                <div class="form-group">
                                    <label for="tgl_lahir" class="form-label text-start">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control form-control-lg"
                                        placeholder="Tanggal Lahir" value="{{ old('tgl_lahir') }}">
                                </div>

                                <div class="form-group">
                                    <label for="no_hp" class="form-label text-start">Nomor HP</label>
                                    <input type="text" name="no_hp" class="form-control form-control-lg"
                                        placeholder="No. HP" value="{{ old('no_hp') }}">
                                </div>

                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file" name="foto" id="foto"
                                        class="form-control form-control-lg" accept="image/*" required>
                                </div>

                                <div class="form-group">
                                    <label for="foto_ktp">Foto KTP</label>
                                    <input type="file" name="foto_ktp" id="foto_ktp"
                                        class="form-control form-control-lg" accept="image/*" required>
                                </div>

                                <div class="form-group">
                                    <label for="foto_dengan_ktp">Foto Dengan KTP</label>
                                    <input type="file" name="foto_dengan_ktp" id="foto_dengan_ktp"
                                        class="form-control form-control-lg" accept="image/*" required>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label text-start">Password Akun</label>
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
