<div class="page-header">
    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper"><a href="{{route('/')}}"><h5
                        class="txt-primary ">{{config('global.project_shortname')}}</h5></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
        <div class="left-header col horizontal-wrapper ps-0">
            <ul class="horizontal-menu">
            </ul>
        </div>
        <div class="nav-right col-8 pull-right right-header p-0">
            <ul class="nav-menus">
                <li class="language-nav">
                    <div class="translate_wrapper">
                        <div class="current_lang">
                            <div class="lang"><i
                                    class="flag-icon flag-icon-{{ (App::getLocale() == 'en') ? 'us' : App::getLocale() }}"></i><span
                                    class="lang-txt">{{ App::getLocale() }} </span></div>
                        </div>
                        <div class="more_lang">
                            <a href="{{ route('lang', 'en' )}}"
                               class="{{ (App::getLocale()  == 'en') ? 'active' : ''}}">
                                <div class="lang {{ (App::getLocale()  == 'en') ? 'selected' : ''}}" data-value="en"><i
                                        class="flag-icon flag-icon-us"></i> <span class="lang-txt">English</span><span> (US)</span>
                                </div>
                            </a>
                            <a href="{{ route('lang' , 'ur' )}}"
                               class="{{ (App::getLocale()  == 'ur') ? 'active' : ''}} ">
                                <div class="lang {{ (App::getLocale()  == 'ur') ? 'selected' : ''}}" data-value="ur"><i
                                        class="flag-icon flag-icon-pk"></i> <span class="lang-txt">اردو</span></div>
                            </a>
                        </div>
                    </div>
                </li>
                @php
                    $notiCnt=0;
                    $notiList='';
                    $pwdExpiry = Auth::user()->pwdExpiry;
                    if(isset($pwdExpiry) && $pwdExpiry!= ''
                        && date('Y-m-d', strtotime($pwdExpiry)) <= date('Y-m-d', strtotime('+10 days'))){
                        $notiCnt=1;
                        $notiList.='<li onclick="showFirstPwdModal(2)"><p><i class="fa fa-circle-o me-3 font-primary"></i>
                        <strong>Password Expiring: </strong> Your password is expiring on '.date('Y-m-d', strtotime($pwdExpiry)).'<span class="pull-right">Now.</span></p></li>';
                    }
                    else{
                        $notiList.='<li><p><i class="fa fa-circle-o me-3 font-primary"></i>No new notification<span class="pull-right">Now.</span></p></li>';
                        }
                @endphp
                <li class="onhover-dropdown">
                    <div class="notification-box"><i data-feather="bell"> </i><span
                            class="badge rounded-pill badge-secondary">{{$notiCnt}}</span></div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li>
                            <i data-feather="bell"></i>
                            <h6 class="f-18 mb-0">Notitications</h6>
                        </li>
                        <?php echo $notiList;?>

                    </ul>
                </li>
                <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li>
                <li class="maximize"><a class="text-dark" href="javascript:void(0)"
                                        onclick="javascript:toggleFullScreen()"><i
                            data-feather="maximize"></i></a></li>
                <li class="profile-nav onhover-dropdown p-0 me-0">
                    <div class="media profile-media">
                        <img class="b-r-10" src="{{asset(config('global.asset_path').'/images/dashboard/profile.jpg')}}"
                             alt="">
                        <div class="media-body">
                            <span>{{ Auth::user()->name }}</span>
                            <p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li><a href="#"><i data-feather="user"></i><span>Account</span></a></li>
                        <li><a href="javascript:void(0)" onclick="showFirstPwdModal(2);"><i data-feather="settings"></i><span>Change Password</span></a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{route('logout')}}"
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i data-feather="log-in"></i>{{ __('LogOut') }}
                                </a>

                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">
                <div class="ProfileCard-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-airplay m-0">
                        <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                        <polygon points="12 15 17 21 7 21 12 15"></polygon>
                    </svg>
                </div>
                <div class="ProfileCard-details">
                    <div class="ProfileCard-realName">@{{name}}</div>
                </div>
            </div>
        </script>
        <script class="empty-template" type="text/x-handlebars-template">
            <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down,
                yikes!
            </div></script>
    </div>
</div>
