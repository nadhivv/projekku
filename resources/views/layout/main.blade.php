<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin</title>
   <!-- plugins:css -->
   <link rel="stylesheet" href="{{asset('vendors/feather/feather.css')}}">
   <link rel="stylesheet" href="{{asset('vendors/ti-icons/css/themify-icons.css')}}">
   <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
   <!-- endinject -->
   <!-- Plugin css for this page -->
   <link rel="stylesheet" href="{{asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
   <link rel="stylesheet" href="{{asset('vendors/ti-icons/css/themify-icons.css')}}">
   <link rel="stylesheet" type="{{asset('text/css')}}" href="{{asset('js/select.dataTables.min.css')}}">
   <!-- End plugin css for this page -->
   <!-- inject:css -->
   <link rel="stylesheet" href="{{asset('css/vertical-layout-light/style.css')}}">
   <!-- endinject -->
   <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" />
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <!-- In layout.main file -->
   <link rel="stylesheet" href="{{asset('https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css')}}">
   <script src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
   <script src="{{asset('https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js')}}"></script>

   <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">


</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include('layout.navbar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="ti-settings"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close ti-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div>
      @include('layout.setting')
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      @include('layout.sidebar')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('layout.footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->


{{-- global-js --}}
<script src="{{asset('vendors/js/vendor.bundle.base.js')}}"></script>
{{-- js-inject --}}
<script src="{{asset('js/off-canvas.js')}}"></script>
<script src="{{asset('js/hoverable-collapse.js')}}"></script>
<script src="{{asset('js/template.js')}}"></script>
<script src="{{asset('js/settings.js')}}"></script>
<script src="{{asset('js/todolist.js')}}"></script>

<script src="{{asset('vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('js/dataTables.select.min.js')}}"></script>

<script src="{{asset('js/dashboard.js')}}"></script>
<script src="{{asset('js/Chart.roundedBarCharts.js')}}"></script>
  {{-- page-js --}}

  <!-- End custom js for this page-->
</body>

</html>

