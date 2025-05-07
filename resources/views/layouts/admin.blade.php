<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Skydash Admin</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/ti-icons/css/themify-icons.css') }}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assetsAdmin/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assetsAdmin/css/vertical-layout-light/style.css') }}">

    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assetsAdmin/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">

        @include('layouts.componentsAdmin.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.componentsAdmin.sidebarSkins')

            @include('layouts.componentsAdmin.todoList')

            @include('layouts.componentsAdmin.sidebar')


            @yield('content')
            
        </div>
    </div>

    <script src="{{ asset('assetsAdmin/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assetsAdmin/vendors/chart.js/Chart.min.js') }}"></script>
    {{-- <script src="{{ asset('assetsAdmin/vendors/datatables.net/jquery.dataTables.js') }}"></script> --}}
    <script src="{{ asset('assetsAdmin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/dataTables.select.min.js') }}"></script>

    <!-- inject:js -->
    <script src="{{ asset('assetsAdmin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/template.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/settings.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/todolist.js') }}"></script>

    <!-- Custom js for this page-->
    <script src="{{ asset('assetsAdmin/js/dashboard.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/Chart.roundedBarCharts.js') }}"></script>
</body>

</html>
