<div id="content_nav" class="jl_mobile_nav_wrapper">
    <div id="nav" class="jl_mobile_nav_inner">
        <div class="menu_mobile_icons mobile_close_icons closed_menu">
            <span class="jl_close_wapper"><span class="jl_close_1"></span><span class="jl_close_2"></span></span>
        </div>
        <ul id="mobile_menu_slide" class="menu_moble_slide">
            <li class="menu-item">
                <a href="#">{{__('lang.website_home')}}<span class="border-menu"></span></a>
            </li>
            <?php $categoryList = \Helpers::getCategoryForSite(); ?>
            @if(isset($categoryList) && count($categoryList))
                @foreach($categoryList as $category)
                    <li class="menu-item">
                        <a href="{{url('/category/'.$category->slug)}}">{{$category->name}}<span class="border-menu"></span></a>
                    </li>
                @endforeach
            @endif
            <li class="menu-item">
                <a href="{{url('all-blogs')}}">{{__('lang.website_all_blogs')}}<span class="border-menu"></span></a>
            </li>
            @if(Auth::user()!='')
            <li class="menu-item">
                <a href="{{url('/profile')}}">{{__('lang.website_my_profile')}}<span class="border-menu"></span></a>
            </li>
            <li class="menu-item">
                <a href="{{url('/saved-stories')}}">{{__('lang.website_saved_stories')}}<span class="border-menu"></span></a>
            </li>
            <li class="menu-item">
                <a href="{{url('/logout')}}">{{__('lang.website_logout')}}<span class="border-menu"></span></a>
            </li>
            @else
            <li class="menu-item">
                <a href="{{url('/login')}}">{{__('lang.website_login')}}<span class="border-menu"></span></a>
            </li>
            @endif
        </ul>
        <span class="jl_none_space"></span>
        <div id="disto_about_us_widget-2" class="widget jellywp_about_us_widget">
            <div class="widget_jl_wrapper about_widget_content">
                <div class="jellywp_about_us_widget_wrapper">
                    <div class="social_icons_widget">
                        <ul class="social-icons-list-widget icons_about_widget_display">                            
                            @if(isset($getSocialMediaForSite) && count($getSocialMediaForSite))
                                @foreach($getSocialMediaForSite as $socialMedia)
                                <li>
                                    <a href="{{$socialMedia->url}}" class="facebook" target="_blank" style="background-color:{{$socialMedia->icon_background_color}} !important"><i class="fa {{$socialMedia->icon}}"></i></a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <span class="jl_none_space"></span>
            </div>
        </div>
    </div>
</div>