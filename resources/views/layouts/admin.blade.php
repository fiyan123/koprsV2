<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | {{ config('app.name', 'KOPERASI') }}</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/ti-icons/css/themify-icons.css') }}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsAdmin/vendors/ti-icons/css/themify-icons.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assetsAdmin/js/select.dataTables.min.css') }}"> --}}
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assetsAdmin/css/vertical-layout-light/style.css') }}">

    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/Logo_New_Juwita.png') }}" />
    <style>
        .logout-link {
            background: none;
            border: none;
            padding: 0;
            margin: 0;
            box-shadow: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .logout-link:hover {
            background: none;
            box-shadow: none;
        }

        .logout-link i {
            font-size: 1.25rem;
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')
    <div class="container-scroller">
        @include('layouts.componentsAdmin.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.componentsAdmin.sidebarSkins')
            @include('layouts.componentsAdmin.todoList')
            @include('layouts.componentsAdmin.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header mb-3">
                        @yield('breadcrumb')
                    </div>
                    <div class="page-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="{{ asset('assetsAdmin/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assetsAdmin/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assetsAdmin/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    {{-- <script src="{{ asset('assetsAdmin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script> --}}
    {{-- <script src="{{ asset('assetsAdmin/js/dataTables.select.min.js') }}"></script> --}}

    <!-- inject:js -->
    <script src="{{ asset('assetsAdmin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/template.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/settings.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/todolist.js') }}"></script>

    <!-- Custom js for this page-->
    <script src="{{ asset('assetsAdmin/js/dashboard.js') }}"></script>
    <script src="{{ asset('assetsAdmin/js/Chart.roundedBarCharts.js') }}"></script>

    {{-- Hightchart --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- jQuery (harus di-load duluan) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    @stack('scripts')
</body>

</html>
