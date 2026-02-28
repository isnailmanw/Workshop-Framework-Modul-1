<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Koleksi Buku')</title>

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

    <!-- Layout CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    @yield('style-page')

    <style>
        /* Hover effect sidebar */
        .sidebar .nav-item .nav-link:hover {
            background: linear-gradient(90deg, #cdb0ef, #d7c0ef);
            color: #ffffff !important;
            border-radius: 4px;
            transition: 0.3s ease;
        }

        .sidebar .nav-item .nav-link:hover i {
            color: #ffffff !important;
        }
    </style>

</head>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<body>

    <div class="container-scroller">

        {{-- Navbar --}}
        @include('layouts.navbar')


        <div class="container-fluid page-body-wrapper">

            {{-- Sidebar --}}
            @include('layouts.sidebar')


            <div class="main-panel">

                <div class="content-wrapper">

                    {{-- Content halaman --}}
                    @yield('content')

                </div>


                {{-- Footer --}}
                @include('layouts.footer')


            </div>

        </div>

    </div>



    <!-- Global JS -->

    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>

    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>



    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>

    <script src="{{ asset('assets/js/misc.js') }}"></script>

    <script src="{{ asset('assets/js/settings.js') }}"></script>

    <script src="{{ asset('assets/js/todolist.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>

    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <!-- jQuery (biasanya sudah ada dari vendor.bundle.base.js) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    {{-- JS khusus halaman --}}
    @yield('js-page')



    {{-- Script tambahan halaman (Datatables, PDF dll) --}}
    @yield('scripts')


</body>

</html>