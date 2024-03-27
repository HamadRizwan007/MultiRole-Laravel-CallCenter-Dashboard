<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard | Gigabite Soft</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/iconfonts/mdi/css/materialdesignicons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/css/vendor.addons.css') }}">
    <!-- endinject -->
    <!-- vendor css for this page -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/shared/style.css') }}">
    <!-- endinject -->
    <!-- Layout style -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo_1/style.css') }}">
    <!-- Layout style -->
    <link rel="shortcut icon" href="{{ asset('backend/asssets/images/favicon.ico')}}" />
  </head>
  <body class="header-fixed">
    <!-- partial:partials/_header.html -->
    @include('admin.body.header')
    <!-- partial -->
    <div class="page-body">
      <!-- partial:partials/_sidebar.html -->
      
      @include('admin.body.sidebar')
      <!-- partial -->
      <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <div class="viewport-header">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb has-arrow">
                <li class="breadcrumb-item">
                  <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Overview</li>
              </ol>
            </nav>
          </div>
          <div class="content-viewport">
            
            @yield('admin')

          </div>
        </div>
        <!-- content viewport ends -->
        <!-- partial:partials/_footer.html -->
        @include('admin.body.footer')
        <!-- partial -->
      </div>
      <!-- page content ends -->
    </div>
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    <script src="{{ asset('backend/assets/vendors/js/core.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/js/vendor.addons.js') }}"></script>
    <!-- endinject -->
    <!-- Vendor Js For This Page Ends-->
    <script src="{{ asset('backend/assets/vendors/chartjs/Chart.min.js') }}"></script>
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="{{ asset('backend/assets/js/template.js') }}"></script>
    <script src="{{ asset('backend/assets/js/dashboard.js') }}"></script>
    <!-- endbuild -->
  </body>
</html>