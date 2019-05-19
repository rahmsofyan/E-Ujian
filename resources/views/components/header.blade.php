<header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="content-header-section">
                        <!-- Logo -->
                        <div class="content-header-item">
                            <a class="link-effect font-w700 mr-5" href="{{url('/')}}">
                                <i class="fa fa-google-wallet text-primary font-size-xl"></i>
                                <span class="font-size-xl text-dual-primary-dark">Log</span><span class="font-size-xl text-primary">Attendance</span>
                            </a>
                        </div>
                        <!-- END Logo -->
                    </div>
                    <!-- END Left Section -->

                    <!-- Middle Section -->
                    <div class="content-header-section d-none d-lg-block">
                        <!-- Header Navigation -->
                        <!--
                        Desktop Navigation, mobile navigation can be found in #sidebar

                        If you would like to use the same navigation in both mobiles and desktops, you can use exactly the same markup inside sidebar and header navigation ul lists
                        If your sidebar menu includes headings, they won't be visible in your header navigation by default
                        If your sidebar menu includes icons and you would like to hide them, you can add the class 'nav-main-header-no-icons'
                        -->
                        <ul class="nav-main-header" >
                            <li>
                                <a style="text-decoration: none;" href="{{url('/')}}"><i class="si si-compass"></i>Dashboard</a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="{{route('download.index')}}"><i class="fa fa-mobile"></i>Download APK</a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="{{route('pic')}}"><i class="fa fa-users"></i>PIC</a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="{{route('ruang')}}"><i class="fa fa-book"></i>Ruang</a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="{{route('agenda')}}"><i class="fa fa-calendar"></i>Agenda</a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="{{route('log')}}"><i class="fa fa-list"></i>Log Attendance</a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="{{route('absenKuliah')}}"><i class="fa fa-check"></i>Absen Kuliah</a>
                            </li>
                            
                             @if(\Auth::check())
                            @if (is_null(\Auth::user()->getPIC())==false && \Auth::user()->getPIC()->exists())
                            <li>
                                <a style="text-decoration: none;" href="{{route('AgendaByPIC')}}"><i class="fa fa-user"></i>My Agenda</a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="{{route('backup')}}"><i class="fa fa-user"></i>Backup</a>
                            </li>
                            <li>
                                <a style="text-decoration: none;" href="{{route('restore')}}"><i class="fa fa-user"></i>Restore</a>
                            </li>
                            @endif
                            @endif
                            
                            @guest
                                <li class="nav-item" style="margin-left:70px;">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                <li class="nav-item">
                                    @if (Route::has('register'))
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                </li>
                            @else
                            <li class="nav-item dropdown" style="margin-left:70px;">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" style="color: black;" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        </ul>
                        <!-- END Header Navigation -->
                    </div>
                    <!-- END Middle Section -->

                    <!-- Right Section -->
                    <div class="content-header-section">
                        <!-- Authentication Links -->

                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->

                <!-- Header Search -->
                <div id="page-header-search" class="overlay-header">
                    <div class="content-header content-header-fullrow">
                        <form action="bd_search.html" method="post">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <!-- Close Search Section -->
                                    <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                                    <button type="button" class="btn btn-secondary px-15" data-toggle="layout" data-action="header_search_off">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <!-- END Close Search Section -->
                                </div>
                                <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary px-15">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Header Search -->

                <!-- Header Loader -->
                <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
                <div id="page-header-loader" class="overlay-header bg-primary">
                    <div class="content-header content-header-fullrow text-center">
                        <div class="content-header-item">
                            <i class="fa fa-sun-o fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
