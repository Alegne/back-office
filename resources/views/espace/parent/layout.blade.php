<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/logo.png">
    <link rel="icon" type="image/png" href="/logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Light Bootstrap Dashboard - Free Bootstrap 4 Admin Dashboard by Creative Tim</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="/espace/fontawesome/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="/espace/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/espace/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="/espace/css/demo.css" rel="stylesheet" />


    @yield('css')
</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-image="/bg-eni.jpg">
        <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

    Tip 2: you can also add an image using data-image tag
-->
        <div class="sidebar-wrapper" style="background-color: #044973 !important;">
            <div class="logo">
                <a href="javascript:;" class="simple-text">
                    <img src="/logo.png" alt="Logo" class="img-circle" style="width: 50px !important; height: 50px !important;">
                    <span>Espace Etudiant</span>
                </a>
            </div>

            <!--  Menu Sidebar  -->
            @include('espace.parent.menu.sidebar')

        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->


        @include('espace.parent.menu.navbar', ['title' => parseRouteActiveSecond()])
        <!-- End Navbar -->

        <div class="content">
            <div class="container-fluid">
                <div class="section">


                    <!-- Navbar -->
                        @yield('content')
                     <!-- End Navbar -->

                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <nav>
                    <ul class="footer-menu"></ul>
                    <p class="copyright text-center">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="#"> Team Cactus</a>
                    </p>
                </nav>
            </div>
        </footer>
    </div>
</div>
</body>
<!--   Core JS Files   -->
<script src="/espace/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="/espace/js/core/popper.min.js" type="text/javascript"></script>
<script src="/espace/js/core/bootstrap.min.js" type="text/javascript"></script>

<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="/espace/js/plugins/bootstrap-switch.js"></script>

<!--  Chartist Plugin  -->
<script src="/espace/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="/espace/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="/espace/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="/espace/js/demo.js"></script>


@yield('script')

</html>
