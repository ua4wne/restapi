<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico"/>

    <title>{{ $title ?? '' }}</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <!-- dataTables -->
    <link href="/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="/css/custom.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="/css/404.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        @section('left_menu')
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ route('home') }}" class="site_title"><i class="fa fa-paw"></i> <span>REST API</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            @if(Auth::user()->image)
                                <img src="{{ Auth::user()->image }}" alt="..." class="img-circle profile_img">
                            @else
                                <img src="/images/male.png" alt="..." class="img-circle profile_img">
                            @endif
                        </div>
                        <div class="profile_info">
                            <span>Здравствуйте,</span>
                            <h2>{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br/>

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Рабочий стол </a></li>
                                @if(Auth::user()->isAdmin())
                                    <li><a href="{{ route('logs') }}"><i class="fa fa-book"></i> Журнал событий </a>
                                    </li>
                                @endif
                                <li><a><i class="fa fa-cog"></i> Настройки <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        @if(Auth::user()->isAdmin())
                                            <li><a href="{{ route('users') }}">Пользователи</a></li>
                                            {{--<li><a href="{{ route('eventlog') }}">Журнал событий</a></li>--}}
                                        @endif
                                        <li><a href="{{ route('devices') }}">Оборудование</a></li>
                                        <li><a href="{{ route('params') }}">Параметры</a></li>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">

                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>
        @show

        @section('top_nav')
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
                                    @if(Auth::user()->image)
                                        <img src="{{ Auth::user()->image }}" alt="...">
                                    @else
                                        <img src="/images/male.png" alt="...">
                                    @endif
                                    {{ Auth::user()->login }}
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="javascript:;"> Профиль</a></li>
                                    <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out pull-right"></i> Log
                                            Out</a></li>
                                </ul>
                            </li>


                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->
        @show
        <div class="right_col" role="main">
        @section('tile_widget')
            <!-- top tiles -->
                <div class="row top_tiles">
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                            <div class="count">179</div>
                            <h3>New Sign ups</h3>
                            <p>Lorem ipsum psdea itgum rixt.</p>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-comments-o"></i></div>
                            <div class="count">179</div>
                            <h3>New Sign ups</h3>
                            <p>Lorem ipsum psdea itgum rixt.</p>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                            <div class="count">179</div>
                            <h3>New Sign ups</h3>
                            <p>Lorem ipsum psdea itgum rixt.</p>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-check-square-o"></i></div>
                            <div class="count">179</div>
                            <h3>New Sign ups</h3>
                            <p>Lorem ipsum psdea itgum rixt.</p>
                        </div>
                    </div>
                </div>
                <!-- /top tiles -->
        @endsection
        @yield('tile_widget')

        @yield('content')

        @section('footer')
            <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Великолепные системы
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="/js/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/js/nprogress.js"></script>
    <!-- iCheck -->
{{--<script src="/js/icheck.min.js"></script>--}}


<!-- Custom Theme Scripts -->
    <script src="/js/custom.min.js"></script>

@show

@section('user_script')
@show

</body>
</html>
