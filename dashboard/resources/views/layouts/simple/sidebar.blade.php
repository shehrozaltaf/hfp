<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="{{route('dashboard')}}">
                <h3 class="txt-primary ">{{config('global.project_shortname')}} </h3>
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{route('dashboard')}}"><h4
                    class="txt-primary ">{{config('global.project_shortname')}} </h4></a></div>
        <nav class="sidebar-main">

            <div class="left-arrow  " id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="{{route('dashboard')}}"><h3 class="txt-primary ">{{config('global.project_shortname')}} </h3>
                        </a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                                                              aria-hidden="true"></i></div>
                    </li>
                    @if(isset($pages) && $pages!='')
                        @foreach($pages as $pk=>$pv)
                            @if($pv->isTitle==1)
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6 class="lan-1">{{ trans('lang.'.$pv->langName) }} </h6>
                                        <p class="lan-2">{{ trans('lang.'.$pv->titlePara) }}</p>
                                    </div>
                                </li>
                            @elseif($pv->isParent==1)

                                @php
                                    $url=request()->route()->getPrefix();
                                @endphp
                                <li class="sidebar-list customparent">
                                    <a class="sidebar-link sidebar-title {{$pv->menuClass}}
                                    {{ $url ==  '/'.$pv->pageUrl ? 'active' : '' }}"
                                       href="javascript:void(0)">
                                        <i data-feather="settings"></i>
                                        <span>{{ trans('lang.'.$pv->langName) }}</span>
                                        <div class="according-menu">
{{--                                            <i class="fa fa-angle-{{ $url ==  '/'.$pv->pageUrl ? 'down' : 'right' }}"></i>--}}
                                        </div>
                                    </a>
                                    <ul class="sidebar-submenu"
                                        style="display: {{ $url ==  '/'.$pv->pageUrl  ? 'block;' : 'none;' }}">
                                        @if(isset($pv->myrow_options) && $pv->myrow_options!='')
                                            @foreach($pv->myrow_options as $ro)
                                                <li><a href="{{ route($ro->pageUrl) }}"
                                                       class=" {{$ro->menuClass}} {{ route::currentRouteName() == $ro->pageUrl ? 'active' : '' }}">{{ trans('lang.'.$ro->langName) }}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @else
                                <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title link-nav {{$pv->menuClass}} {{ route::currentRouteName()==$pv->pageUrl ? 'active' : '' }}"
                                       href="{{route($pv->pageUrl)}}">
                                        <i data-feather="{{$pv->menuIcon}}"> </i>
                                        <span>{{ trans('lang.'.$pv->langName) }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                    {{-- <li class="sidebar-main-title">
                         <div>
                             <h6 class="lan-1">{{ trans('lang.General') }} </h6>
                             <p class="lan-2">{{ trans('lang.Dashboards,widgets & layout.') }}</p>
                         </div>
                     </li>
                    <li class="sidebar-list"><a
                            class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='index' ? 'active' : '' }}"
                            href="{{route('/')}}"><i
                                data-feather="home"> </i><span>{{ trans('lang.Dashboards') }}</span></a></li>
                    <li class="sidebar-list"><a
                            class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='App_Users' ? 'active' : '' }}"
                            href="{{route('App_Users')}}"><i
                                data-feather="user"> </i><span>{{ trans('lang.App_Users') }}</span></a></li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title {{ request()->route()->getPrefix() == '/settings' ? 'active' : '' }}"
                           href="#">
                            <i data-feather="settings"></i>
                            <span>{{ trans('lang.Settings') }}</span>
                            <div class="according-menu"><i
                                    class="fa fa-angle-{{ request()->route()->getPrefix() == '/settings' ? 'down' : 'right' }}"></i>
                            </div>
                        </a>
                        <ul class="sidebar-submenu"
                            style="display: {{ request()->route()->getPrefix() == '/settings' ? 'block;' : 'none;' }}">
                            <li><a href="{{ route('groups') }}"
                                   class="{{ Route::currentRouteName() == 'groups' ? 'active' : '' }}">{{ trans('lang.Groups') }}</a>
                            </li>
                            <li><a href="{{ route('pages') }}"
                                   class="{{ Route::currentRouteName() == 'pages' ? 'active' : '' }}">{{ trans('lang.Pages') }}</a>
                            </li>
                            <li><a href="{{ route('dashboard_users') }}"
                                   class="{{ Route::currentRouteName() == 'dashboard_users' ? 'active' : '' }}">{{ trans('lang.Dashboard_Users') }}</a>
                            </li>
                        </ul>
                    </li>--}}


                </ul>
            </div>
            <div class="right-arrow  " id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
