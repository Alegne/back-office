<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ENI | Dashboard </title>

  <meta name="csrf-token" content="{{ csrf_token() }}">


  <link rel="icon" type="image/*" href="/logo.png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/admin/dist/css/adminlte.css">

  <!-- Select 2 -->
  <link rel="stylesheet" href="/admin/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

  <!-- Section Styles -->
  @yield('css')

  <style>
    .bg-navbar{
      background-color:#044973 !important;
    }

    .bg-sidebar{
      background-color: #044973!important;
    }

    .bg-body{
      background-color: #E6DADE !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed bg-body">

  <!-- Wrapper Site|App     dark-mode -->
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="/logo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light bg-navbar">

      <!-- Left navbar links -->
      <ul class="navbar-nav mr-auto">

        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

      </ul>

      <a class="navbar-brand" href="{{ route('dashboard.webcup') }}">
        <h2 class="text-light">Ecole Nationale d'Infomatique</h2>
      </a>
      <!-- include/left_navbar_links.html -->

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Navbar Search -->
        <!-- include/navbar_search.html -->

        <!-- Messages Dropdown Menu -->
        <!-- messages_dropdown_menu.html -->

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell" style="color: white"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>

        <!-- fullscreen -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt" style="color: white"></i>
          </a>
        </li>

        <!-- control-sidebar Paramatrage -->
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large" style="color: white"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-sidebar">
      <!-- Brand Logo -->
      <a href="{{ route('dashboard.webcup') }}" class="brand-link bg-sidebar">
        <img src="/logo.png" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Back Office</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Administrateur</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- sidebarSearch_form.html -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            {{-- Parcourir menu config --}}
            @foreach(config('menu') as $name => $elements)

                {{-- Si element possede un children --}}
                @isset($elements['children'])

                  {{-- MenuOpen return 'menu-open' --}}
                  <li class="nav-item has-treeview {{ menuOpen($elements['children']) }}">

                    {{-- currentChildActive return 'active'--}}
                    <a href="#" class="nav-link {{ currentChildActive($elements['children']) }}">
                      <i class="nav-icon fas fa-{{ $elements['icon'] }}"></i>
                      <p>
                        @lang($name)
                        <i class="right fas fa-angle-left"></i>
                        {{-- <i class="fas fa-angle-left right"></i>--}}
                      </p>
                    </a>
                    <ul class="nav nav-treeview" style="width: 200px !important; margin-left: 30px !important;">

                      {{-- Parcourir children --}}
                      @foreach($elements['children'] as $child)

                        {{-- Si element doit afficher au role redac --}}
{{--                        @if(($child['role'] === 'redac' || auth()->user()->isAdmin()) && $child['name'] !== 'fake')--}}


                          {{-- Appel  composant menu-item.blade.php --}}
                          <x-back.menu-item
                                  :route="$child['route']"
                                  :sub=true>
                            @lang($child['name'])
                          </x-back.menu-item>
                        {{--@endif--}}
                      @endforeach
                    </ul>
                  </li>

                  {{-- Si element ne possede pas un children --}}
                @else

                  {{-- Appel  composant menu-item.blade.php --}}
                  <x-back.menu-item
                          :route="$elements['route']"
                          :icon="$elements['icon']">
                    @lang($name)
                  </x-back.menu-item>
                @endisset
            @endforeach

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"></a></li>
                <li class="breadcrumb-item active"></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- Section Contenu -->
          @yield('main')

        </div><!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; march 2021 <a href="#">NRH [Crew Cactus]</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="/admin/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/admin/dist/js/adminlte.min.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="/admin/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="/admin/plugins/raphael/raphael.min.js"></script>
  <script src="/admin/plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="/admin/plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="/admin/plugins/chart.js/Chart.min.js"></script>

  <!-- Select 2 -->
  <script src="/admin/plugins/select2/js/select2.min.js"></script>

  <!-- Tempusdominus Bootstrap 4 -->
  <script src="/admin/plugins/moment/moment.min.js"></script>
  <script src="/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

  <!-- AdminLTE for demo purposes -->
  <!--<script src="dist/js/demo.js"></script>-->
  <script src="/admin/dist/js/admin.js"></script>


  <script>
    $(document).ready(function() {
      $('.select-multiple').select2();
      $('#modal-specification').select2();

      // $('.select-single').select2();

      // $('[type="date"]').datepicker();

      //Date picker
      // $('.input-date').datepicker();

      $('.input-date').datetimepicker();
    });
  </script>



<script src="/admin/plugins/ckeditor/ckeditor.js"></script>

<script>
  ClassicEditor
      .create( document.querySelector( 'textarea' ) )
      .catch( error => {
          console.error( error );
      } );
</script>


  <!-- Section Scripts -->
  @yield('js')

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="/admin/dist/js/pages/dashboard2.js" defer></script>

</body>
</html>
