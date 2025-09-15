        <!--=================================
 header start-->
        <nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <!-- logo -->
            <div class="text-left navbar-brand-wrapper">
                <a class="navbar-brand brand-logo" href="#"><img
                        src="{{ URL::asset('assets/images/logo-dark.png') }}" alt=""></a>
                <a class="navbar-brand brand-logo-mini" href="#"><img
                        src="{{ URL::asset('assets/images/favicon.ico') }}" alt=""></a>
            </div>
            <!-- Top bar left -->
            <ul class="nav navbar-nav mr-auto">
                <li class="nav-item">
                    <a id="button-toggle" class="button-toggle-nav inline-block ml-20 pull-left"
                        href="javascript:void(0);"><i class="zmdi zmdi-menu ti-align-right"></i></a>
                </li>
                <li class="nav-item">
                    <div class="search">
                        <a class="search-btn not_click" href="javascript:void(0);"></a>
                        <div class="search-box not-click">
                            <input type="text" class="not-click form-control" placeholder="Search" value=""
                                name="search">
                            <button class="search-button" type="submit"> <i
                                    class="fa fa-search not-click"></i></button>
                        </div>
                    </div>
                </li>
                @if (Request::routeIs('dashboard'))
                    <li class="nav-item" style="margin-top: 11px;margin-right: -6px;">
                        <a class="nav-link top-nav" data-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-repeat me-1" aria-hidden="true" id="update_data"></i>
                            <span class="badge badge-danger notification-status"></span>
                        </a>
                    </li>
                @endif
            </ul>
            <!-- top bar right -->
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item fullscreen">
                    <a id="btnFullscreen" href="#" class="nav-link"><i class="ti-fullscreen"></i></a>
                </li>
                <li class="nav-item dropdown mr-30">
                    <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                          <img src="{{ Auth::user()->image && file_exists(public_path('assets/images/team/' . Auth::user()->image)) ? URL::asset('assets/images/team/' . Auth::user()->image) : URL::asset('assets/images/profile-avatar.png') }}" 
                            alt="avatar">

                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header">
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0">{{ Auth::user()->name }}</h5>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        {{-- <a class="dropdown-item" href="#"><i class="text-secondary ti-reload"></i>Activity</a> --}}
                        {{-- <a class="dropdown-item" href="#"><i class="text-success ti-email"></i>Messages</a> --}}
                        <a class="dropdown-item" href="#"><i
                                class="text-warning ti-user"></i>الملف الشخصي</a>
                        {{-- <a class="dropdown-item" href="#"><i class="text-dark ti-layers-alt"></i>Projects <span
                                class="badge badge-info">6</span> </a>
                        <div class="dropdown-divider"></div> --}}
                        <a class="dropdown-item" href="#"><i
                                class="text-info ti-settings"></i>إعدادات النظام</a>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                class="text-danger ti-unlock"></i>تسجيل الخروج</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!--=================================header End-->
