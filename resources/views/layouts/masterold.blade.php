<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>

    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta content="LandVilleApp" name="description">
    <meta content="JayP UG Private Technologies" name="author">
    <meta name="keywords" content="Land, Ville, LandVille, Landville, ville, land"/>

    <!-- Title -->
    <title>LandVille App</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>

    <script src="https://cdn.tiny.cloud/1/xx5mptqws192s7zami0i0p3642ok8ft2lyb0cazd3k2fthd0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <!--Favicon -->
    <link rel="icon" href="/assets/images/brand/Landville_logo.png" type="image/x-icon"/>

    <!-- Bootstrap css -->
    <link href="/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />

    <!-- Style css -->
    <link href="/assets/css/style.css" rel="stylesheet" />

    <!-- Dark css -->
    <link href="/assets/css/dark.css" rel="stylesheet" />

    <!-- Skins css -->
    <link href="/assets/css/skins.css" rel="stylesheet" />

    <!-- Animate css -->
    <link href="/assets/css/animated.css" rel="stylesheet" />

    <!--Sidemenu css -->
    <link id="theme" href="/assets/css/sidemenu.css" rel="stylesheet">

    <!-- P-scroll bar css-->
    <link href="/assets/plugins/p-scrollbar/p-scrollbar.css" rel="stylesheet" />

    <!---Icons css-->
    <link href="/assets/plugins/web-fonts/icons.css" rel="stylesheet" />
    <link href="/assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/plugins/web-fonts/plugin.css" rel="stylesheet" />

    <!---jvectormap css-->
    <link href="/assets/plugins/jvectormap/jqvmap.css" rel="stylesheet" />

    <!-- Data table css -->
    <link href="/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />

    <!--Daterangepicker css-->
    <link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />

</head>

<style type="text/css">
    h2{
        text-align: center;
        font-size:22px;
        margin-bottom:50px;
    }
    body{
        background:#f2f2f2;
    }
    .section{
        margin-top:150px;
        padding:50px;
        background:#fff;
    }
</style>

<body class="app sidebar-mini light-mode default-sidebar">

<!---Global-loader-->
<div id="global-loader" >
    <img src="/assets/images/svgs/loader.svg" alt="loader">
</div>

<div class="page">
    <div class="page-main">

        <!--aside open-->
        <div class="app-sidebar app-sidebar2">
            <div class="app-sidebar__logo">
                <a class="header-brand" href="/dashboard">
                    <h1>Tree Clinic</h1>
                    <img src="/assets/images/brand/logo1.png" class="header-brand-img dark-logo" alt="Covido logo">
                    <img src="/assets/images/brand/favicon.png" class="header-brand-img mobile-logo" alt="Covido logo">
                    <img src="/assets/images/brand/favicon1.png" class="header-brand-img darkmobile-logo" alt="Covido logo">
                </a>
            </div>
        </div>
        <aside class="app-sidebar app-sidebar3">

            <ul class="side-menu">
                <li class="slide">
                    <a class="side-menu__item" href="/dashboard" >
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="side-menu__label">Dashboard</span> </a>

                </li>
                <li class="slide">
                    <a class="side-menu__item"  href="{{ route('categories.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="side-menu__icon"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span class="side-menu__label">Categories</span> </a>

                </li>
                <li class="slide">
                    <a class="side-menu__item"  href="/users">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span class="side-menu__label">Users</span> </a>

                </li>
                <li class="slide">
                    <a class="side-menu__item"  href="{{ route('teams.index') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span class="side-menu__label">Teams</span> </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item"  href="{{ route('districts.index') }}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                        <span class="side-menu__label">Districts</span> </a>

                </li>
                <li class="slide">

                </li>

        </aside>
        <!--aside closed-->

        <div class="app-content main-content">
            <div class="side-app">

                <!--app header-->
                <div class="app-header header top-header">
                    <div class="container-fluid">
                        <div class="d-flex">
                            <div class="d-flex order-lg-2 ml-auto">
                                <div class="pt-4 pb-1 border-t border-gray-200">
                                    <div class="px-4">
                                        <div class="font-medium text-base text-gray-800"><b>Welcome</b> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><b>Log Out<b></a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/app header-->


            @yield('content')

        </div>



        <!-- Jquery js-->
        <script src="/assets/js/vendors/jquery-3.5.1.min.js"></script>

        <!-- Bootstrap4 js-->
        <script src="/assets/plugins/bootstrap/popper.min.js"></script>
        <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

        <!--Othercharts js-->
        <script src="/assets/plugins/othercharts/jquery.sparkline.min.js"></script>

        <!-- Circle-progress js-->
        <script src="/assets/js/vendors/circle-progress.min.js"></script>

        <!-- Jquery-rating js-->
        <script src="/assets/plugins/rating/jquery.rating-stars.js"></script>

        <!--Sidemenu js-->
        <script src="/assets/plugins/sidemenu/sidemenu.js"></script>
        <!-- Apexchart js-->
        <script src="/assets/js/apexcharts.js"></script>
        <!-- P-scroll js-->
        <script src="/assets/plugins/p-scrollbar/p-scrollbar.js"></script>
        <script src="/assets/plugins/p-scrollbar/p-scroll1.js"></script>

        <!-- ECharts js -->
        <script src="/assets/plugins/echarts/echarts.js"></script>

        <!-- Peitychart js-->
        <script src="/assets/plugins/peitychart/jquery.peity.min.js"></script>
        <script src="/assets/plugins/peitychart/peitychart.init.js"></script>


        <!--Moment js-->
        <script src="/assets/plugins/moment/moment.js"></script>

        <!-- Daterangepicker js-->
        <script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="/assets/js/daterange.js"></script>


        <!-- Index js-->
        <script src="/assets/js/index1.js"></script>

        <!-- Data tables js-->
        <script src="/assets/plugins/datatable/js/jquery.dataTables.js"></script>
        <script src="/assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
        <script src="/assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
        <script src="/assets/plugins/datatable/js/buttons.bootstrap4.min.js"></script>
        <script src="/assets/plugins/datatable/js/jszip.min.js"></script>
        <script src="/assets/plugins/datatable/js/pdfmake.min.js"></script>
        <script src="/assets/plugins/datatable/js/vfs_fonts.js"></script>
        <script src="/assets/plugins/datatable/js/buttons.html5.min.js"></script>
        <script src="/assets/plugins/datatable/js/buttons.print.min.js"></script>
        <script src="/assets/plugins/datatable/js/buttons.colVis.min.js"></script>
        <script src="/assets/plugins/datatable/dataTables.responsive.min.js"></script>
        <script src="/assets/plugins/datatable/responsive.bootstrap4.min.js"></script>
        <script src="/assets/js/datatables.js"></script>

        <!--Counters -->
        <script src="/assets/plugins/counters/counterup.min.js"></script>
        <script src="/assets/plugins/counters/waypoints.min.js"></script>

        <!--Chart js -->
        <script src="/assets/plugins/chart/chart.bundle.js"></script>
        <script src="/assets/plugins/chart/utils.js"></script>

        <!-- Custom js-->
        <script src="/assets/js/custom.js"></script>

        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" type="text/javascript"></script>

        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


        <script type="text/javascript">

            tinymce.init({

                selector: 'textarea.tinymce-editor',

                width: 900,
                height: 300,

                menubar: false,

                plugins: [

                    'advlist autolink lists link image charmap print preview anchor',

                    'searchreplace visualblocks code fullscreen',

                    'insertdatetime media table paste code help wordcount'

                ],

                toolbar: 'undo redo | formatselect | ' +

                'bold italic backcolor | alignleft aligncenter ' +

                'alignright alignjustify | bullist numlist outdent indent | ' +

                'removeformat | help',

                content_css: '//www.tiny.cloud/css/codepen.min.css'

            });

        </script>


</body>
</html>
