<header class="header-wraper header_magazine_full_screen header_magazine_full_screen options_dark_header jl_cus_sihead jl_head_lobl">
    <div class="jl_topa_blank_nav"></div>
    <div id="menu_wrapper" class="menu_wrapper jl_topa_menu_sticky">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- main menu -->
                    <div class="menu-primary-container navigation_wrapper header_layout_style1_custom">
                        @include('site/layout/components/header_menu') 
                        <div class="clearfix"></div>
                    </div>
                    <!-- end main menu -->
                    <div class="search_header_menu jl_left_share">
                        <ul class="social_icon_header_top">
                            <?php $getSocialMediaForSite = \Helpers::getSocialMediaForSite(); ?>
                            @if(isset($getSocialMediaForSite) && count($getSocialMediaForSite)< 3)
                                @for($i = 0; $i < count($getSocialMediaForSite); $i++)
                                <li>
                                    <a href="{{$getSocialMediaForSite[$i]->url}}"  target="_blank"><i class="fa {{$getSocialMediaForSite[$i]->icon}}"></i></a>
                                </li>
                                @endfor
                            @endif
                        </ul>
                    </div>
                    <div class="search_header_menu">
                        <div class="menu_mobile_icons"><i class="fa fa-bars"></i></div>
                        <div class="search_header_wrapper search_form_menu_personal_click"><i class="fa fa-search"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- begin logo -->
    <div class="jl_logo_tm">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="jl_lgin">
                        <a class="logo_link" href="{{url('/')}}">
                            <img class="logo_black" src="{{ url('uploads/setting/'.setting('site_logo'))}}" alt="{[setting('site_name')]}" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-logo-image.png') }}`"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end logo -->
</header>
@include('site/layout/components/side-menu') 
<div class="search_form_menu_personal">
    <div class="menu_mobile_large_close">
        <span class="jl_close_wapper search_form_menu_personal_click"><span class="jl_close_1"></span><span class="jl_close_2"></span></span>
    </div>
    <form method="get" class="searchform_theme" action="{{url('search-blog')}}">
        <input type="text" placeholder="{{ __("lang.site_search") }}" name="keyword" class="search_btn" />
        <button type="submit" class="button"><i class="fa fa-search fa-2x"></i></button>
    </form>
</div>
<div class="mobile_menu_overlay"></div>