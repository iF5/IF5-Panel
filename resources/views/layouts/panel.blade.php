<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IF5 | @yield('title') </title>

    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}"
          rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">

</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    {{--<a href="{{ url('dashboard') }}" class="site_title"><i class="fa fa-paw"></i> <span>IF5</span></a>--}}
                    <a href="{{ url('home') }}" class="site_title">
                        <img src="{{ asset('images/if5-logo.jpg') }}" width="120" alt="IF5">
                    </a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="{{ asset('images/profile/'. Auth::user()->image) }}" alt="..."
                             class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Ol&aacute;,</span>
                        <h2>{{ Auth::user()->name }}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <ul class="nav side-menu">
                        <!--<li><a><i class="fa fa-home"></i> Dashboard <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="{{ url('dashboard') }}">Cliente/Prestador</a></li>
                                    <li><a href="{{ url('dashboard-employee') }}">Funcion&aacute;rios</a></li>
                                </ul>
                            </li>-->
                            <!--
                            <li><a><i class="fa fa-check-square-o"></i> Checklist <span class="fa fa-chevron-down"></span></a>
                            </li>
                            -->
                            @can('onlyAdmin')
                                <li>
                                    <a href="{{ route('user-admin.index') }}"><i class="fa fa-users"></i>
                                        Usu&aacute;rios admin
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('company.index') }}"><i class="fa fa-building-o"></i> Clientes
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-check"></i>Pendências<span
                                                class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('pendency.index', ['source' => 'provider']) }}">Prestadores
                                                de
                                                servi&ccedil;os </a></li>
                                        <li><a href="{{ route('pendency.index', ['source' => 'employee']) }}">Funcion&aacute;rios</a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan

                            @can('onlyCompany')
                                <li>
                                    <a href="{{ route('user-company.index') }}"><i class="fa fa-users"></i> Usu&aacute;rios
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('provider.index') }}"><i class="fa fa-briefcase"></i> Prestadores
                                        de
                                        servi&ccedil;os </a>
                                </li>
                                <li>
                                    <a href="{{ route('report.index') }}"><i class="fa fa-bar-chart-o"></i>
                                        Relat&oacute;rios
                                    </a>
                                </li>
                            @endcan

                            @can('onlyProvider')
                                <li>
                                    <a href="{{ route('user-provider.index') }}"><i class="fa fa-users"></i> Usu&aacute;rios
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('employee.index') }}"><i class="fa fa-arrow-circle-up"></i>
                                        Funcion&aacute;rios </a>
                                </li>
                            @endcan

                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img src="{{ asset('images/profile/'. Auth::user()->image) }}"
                                     alt="">{{ Auth()->user()->name }}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                    <a href="{{ route('profile.index') }}">
                                        <!--<span class="badge bg-red pull-right">50%</span>-->
                                        <span>Perfil</span>
                                    </a>
                                </li>
                                <li><a href="#">Ajuda</a></li>
                                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out pull-right"></i>Sair </a>
                                </li>
                            </ul>
                        </li>

                        @can('onlyAdmin')
                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    @if(app('NotificationController')->load()['total'] > 0)
                                        <span class="badge bg-green">{{ app('NotificationController')->load()['total'] }}</span>
                                    @endif
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    @foreach(app('NotificationController')->load()['items'] as $items)
                                        <li>
                                            <a href="{{ $items['link'] }}">
                                                <span>{{ $items['label'] }}</span>
                                                <span class="time">{{ $items['total'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endcan
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
    @yield('content')
    <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                &copy; 2005 - 2017 - fone:(11) 0000.0000 ou 0000.0000 - IF5
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

@include('includes.modal')

<!-- jQuery -->
<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.maskedinput.min.js') }}" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}" type="text/javascript"></script>
<!-- NProgress -->
<script src="{{ asset('vendors/nprogress/nprogress.js') }}" type="text/javascript"></script>
<!-- Chart.js -->
<script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}" type="text/javascript"></script>
<!-- gauge.js -->
<script src="{{ asset('vendors/gauge.js/dist/gauge.min.js') }}" type="text/javascript"></script>
<!-- bootstrap-progressbar -->
<script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}" type="text/javascript"></script>
<!-- iCheck -->
<script src="{{ asset('vendors/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<!-- Skycons -->
<script src="{{ asset('vendors/skycons/skycons.js') }}" type="text/javascript"></script>
<!-- Flot -->
<script src="{{ asset('vendors/Flot/jquery.flot.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/Flot/jquery.flot.stack.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}" type="text/javascript"></script>
<!-- Flot plugins -->
<script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}" type="text/javascript"></script>
<!-- DateJS -->
<script src="{{ asset('vendors/DateJS/build/date.js') }}" type="text/javascript"></script>
<!-- JQVMap -->
<script src="{{ asset('vendors/jqvmap/dist/jquery.vmap.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}" type="text/javascript"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('vendors/moment/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- Datatables -->
<script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/dropzone.js') }}" type="text/javascript"></script>

<!-- Custom Theme Scripts -->
<script src="{{ asset('build/js/custom.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/if5.js') }}" type="text/javascript"></script>

</body>
</html>



