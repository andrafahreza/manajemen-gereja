<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/assets/css/horizontal-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/assets/images/favicon.png" />

    @stack("styles")
</head>

<body>
    <div class="container-scroller">
        @include('front.layouts.components.menu')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                @yield('content')
                @include('front.layouts.components.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
</body>

</html>
