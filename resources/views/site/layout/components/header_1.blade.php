<?php $categories_header = \Helpers::getCategoryForSite(0);?>
<header class="container-fluid no-left-padding no-right-padding header_s header-fix header_s3">
    <!-- Menu Block -->
    <div class="container-fluid no-left-padding no-right-padding menu-block">
        <!-- Container -->
        <div class="container">				
            <nav class="navbar ownavigation navbar-expand-lg">
                <a class="navbar-brand" href="{{url('/')}}" style="margin: 0px 0 0px;">
                    <img src="{{ url('uploads/setting/'.setting('site_logo'))}}" alt="{{setting('site_name')}}" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-logo-image.png') }}`" style="width: 200px;"/>
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar4" aria-controls="navbar4" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbar4">
                    <ul class="navbar-nav justify-content-end">
                        <li><a class="nav-link" title="{{__('lang.website_home')}}" href="{{url('/')}}">{{__('lang.website_home')}}</a></li>
                        @if(isset($categories_header) && count($categories_header))
                        @for($i=0;$i< 3;$i++)
                        @if(isset($categories_header[$i]) && $categories_header[$i]!='')
                        @if(isset($categories_header[$i]->sub_category) && count($categories_header[$i]->sub_category))
                            <li class="dropdown">
                                <i class="ddl-switch fa fa-angle-down"></i>
                                <a class="nav-link dropdown-toggle" title="{{$categories_header[$i]->name}}" href="#">{{$categories_header[$i]->name}}</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('category/'.$categories_header[$i]->slug)}}" title="{{__('lang.website_all')}} {{$categories_header[$i]->name}}">{{__('lang.website_all')}} {{$categories_header[$i]->name}}</a></li>
                                    @foreach($categories_header[$i]->sub_category as $sub_category)
                                    <li><a class="dropdown-item" href="{{url('category/'.$categories_header[$i]->slug.'/'.$sub_category->slug)}}" title="{{$sub_category->name}}">{{$sub_category->name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li><a class="nav-link" title="{{$categories_header[$i]->name}}" href="{{url('category/'.$categories_header[$i]->slug)}}">{{$categories_header[$i]->name}}</a></li>
                        @endif
                        @endif
                        @endfor
                        @if(count($categories_header)>3)
                        <li class="dropdown">
                            <i class="ddl-switch fa fa-angle-down"></i>
                            <a class="nav-link dropdown-toggle" title="{{__('lang.website_more')}}" href="#">{{__('lang.website_more')}}</a>
                            <ul class="dropdown-menu">
                                @for($j=3;$j < count($categories_header);$j++)
                                <li><a class="dropdown-item" href="{{url('category/'.$categories_header[$j]->slug)}}" title="{{$categories_header[$j]->name}}">{{$categories_header[$j]->name}}</a></li>
                                @endfor
                            </ul>
                        </li>
                        @endif
                        @endif
                        <li><a class="nav-link" title="{{__('lang.website_all_blogs')}}" href="{{url('all-blogs')}}">{{__('lang.website_all_blogs')}}</a></li>
                        <li><a class="nav-link premium-link" title="{{ __("lang.site_membership") }}" href="{{url('membership/plans')}}">
                            <i class="fa fa-crown"></i> Membership
                        </a></li>
                        <li><a class="nav-link donate-link" title="{{ __("lang.site_donate") }}" href="{{url('donation')}}">
                            <i class="fa fa-heart"></i> Donate
                        </a></li>
                    </ul>
                </div>
                <ul class="user-info">
                    <li><a href="#search-box" data-toggle="collapse" class="search collapsed" title="{{ __("lang.site_search") }}"><i class="pe-7s-search sr-ic-open"></i><i class="pe-7s-close sr-ic-close"></i></a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle user-menu" href="#"><i class="pe-7s-user"></i></a>
                        <ul class="dropdown-menu user-dropdown">
                            @if(Auth::user()!='')
                                <li class="dropdown-header">
                                    <div class="user-info-header">
                                        <div class="user-avatar">
                                            <i class="pe-7s-user"></i>
                                        </div>
                                        <div class="user-details">
                                            <h6>{{Auth::user()->name}}</h6>
                                            <span class="user-email">{{Auth::user()->email}}</span>
                                            @if(Auth::user()->hasActiveSubscription())
                                                <span class="subscription-badge">Premium Member</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{url('profile')}}" title="{{__('lang.website_my_profile')}}">
                                    <i class="fa fa-user"></i> {{__('lang.website_my_profile')}}
                                </a></li>
                                <li><a class="dropdown-item" href="{{url('saved-stories')}}" title="{{__('lang.website_saved_stories')}}">
                                    <i class="fa fa-bookmark"></i> {{__('lang.website_saved_stories')}}
                                </a></li>
                                @if(Auth::user()->hasActiveSubscription())
                                    <li><a class="dropdown-item premium-item" href="{{url('membership/subscription')}}" title="{{ __("lang.site_my_subscription") }}">
                                        <i class="fa fa-crown"></i> My Subscription
                                    </a></li>
                                @else
                                    <li><a class="dropdown-item upgrade-item" href="{{url('membership/plans')}}" title="{{ __("lang.site_get_premium") }}">
                                        <i class="fa fa-star"></i> Get Premium
                                    </a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{route('transactions.index')}}" title="{{ __("lang.site_my_transactions") }}">
                                    <i class="fa fa-receipt"></i> Mes Transactions
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{url('logout')}}" title="{{__('lang.website_logout')}}">
                                    <i class="fa fa-sign-out"></i> {{__('lang.website_logout')}}
                                </a></li>
                            @else
                                <li><a class="dropdown-item" href="{{url('login')}}" title="{{__('lang.website_signin')}}">
                                    <i class="fa fa-sign-in"></i> {{__('lang.website_signin')}}
                                </a></li>
                                <li><a class="dropdown-item" href="{{url('signup')}}" title="{{__('lang.website_signup')}}">
                                    <i class="fa fa-user-plus"></i> {{__('lang.website_signup')}}
                                </a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </nav>
        </div><!-- Container /- -->
    </div><!-- Menu Block /- -->
    <!-- Search Box -->
    <div class="search-box collapse" id="search-box">
        <div class="container">
            <form action="{{url('search-blog')}}" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="{{ __("lang.site_search_articles") }}" name="keyword" required>
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="submit"><i class="pe-7s-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <!-- Search Box /- -->
</header>
<!-- Header Section /- -->

<style>
/* Header Modern Styles */
.header_s {
    background: rgba(26, 26, 46, 0.95);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--border-color);
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    transition: var(--transition);
    padding: 1rem 0;
}

.navbar-brand img {
    max-height: 50px;
    transition: var(--transition);
}

.navbar-nav .nav-link {
    color: var(--text-primary) !important;
    font-weight: 500;
    padding: 1rem 1.5rem !important;
    transition: var(--transition);
    position: relative;
    border-radius: var(--border-radius);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.navbar-nav .nav-link:hover {
    color: var(--text-primary) !important;
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.navbar-nav .nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: var(--accent-color);
    transition: var(--transition);
    transform: translateX(-50%);
}

.navbar-nav .nav-link:hover::after {
    width: 80%;
}

/* Premium and Donate Links */
.premium-link {
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    color: #000 !important;
    font-weight: 700;
    border-radius: var(--border-radius-xl);
    margin: 0 0.5rem;
}

.premium-link:hover {
    background: linear-gradient(135deg, #ffed4e, #ffd700);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
}

.donate-link {
    background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    color: #fff !important;
    font-weight: 700;
    border-radius: var(--border-radius-xl);
    margin: 0 0.5rem;
}

.donate-link:hover {
    background: linear-gradient(135deg, #ee5a52, #ff6b6b);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
}

/* Dropdown Styles */
.dropdown-menu {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-heavy);
    padding: 1rem 0;
    margin-top: 0.5rem;
    min-width: 250px;
}

.dropdown-item {
    color: var(--text-secondary);
    padding: 0.75rem 1.5rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.dropdown-item:hover {
    background: var(--accent-color);
    color: var(--text-primary);
    transform: translateX(5px);
}

.dropdown-item i {
    width: 16px;
    text-align: center;
}

/* User Dropdown */
.user-dropdown {
    min-width: 280px;
}

.dropdown-header {
    padding: 1rem 1.5rem;
    background: var(--secondary-color);
    border-bottom: 1px solid var(--border-color);
}

.user-info-header {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    width: 50px;
    height: 50px;
    background: var(--accent-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--text-primary);
}

.user-details h6 {
    margin: 0;
    color: var(--text-primary);
    font-weight: 600;
}

.user-email {
    color: var(--text-secondary);
    font-size: 0.9rem;
    display: block;
    margin-bottom: 0.5rem;
}

.subscription-badge {
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    color: #000;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
}

.dropdown-divider {
    border-color: var(--border-color);
    margin: 0.5rem 0;
}

.premium-item {
    background: linear-gradient(135deg, rgba(255, 215, 0, 0.1), rgba(255, 237, 78, 0.1));
    border-left: 3px solid #ffd700;
}

.upgrade-item {
    background: linear-gradient(135deg, rgba(15, 52, 96, 0.1), rgba(83, 52, 131, 0.1));
    border-left: 3px solid var(--accent-color);
}

/* Search Box */
.search-box {
    background: var(--card-bg);
    border-top: 1px solid var(--border-color);
    padding: 2rem 0;
}

.search-box .form-control {
    background: var(--secondary-color);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    border-radius: var(--border-radius-xl);
    padding: 1rem 1.5rem;
    font-size: 1.1rem;
}

.search-box .form-control:focus {
    background: var(--secondary-color);
    border-color: var(--accent-color);
    color: var(--text-primary);
    box-shadow: 0 0 0 0.2rem rgba(15, 52, 96, 0.25);
}

.search-box .btn {
    background: var(--accent-color);
    border: none;
    border-radius: var(--border-radius-xl);
    padding: 1rem 1.5rem;
    color: var(--text-primary);
    font-weight: 600;
    transition: var(--transition);
}

.search-box .btn:hover {
    background: var(--hover-color);
    transform: translateY(-2px);
}

/* User Info */
.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 0;
    padding: 0;
    list-style: none;
}

.user-info li a {
    color: var(--text-primary);
    font-size: 1.2rem;
    padding: 0.5rem;
    border-radius: 50%;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
}

.user-info li a:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-primary);
    transform: scale(1.1);
}

.user-menu {
    position: relative;
}

.user-menu::after {
    content: '';
    position: absolute;
    top: 50%;
    right: -5px;
    width: 0;
    height: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid var(--text-primary);
    transform: translateY(-50%);
}

/* Responsive Design */
@media (max-width: 768px) {
    .header_s {
        padding: 0.5rem 0;
    }

    .navbar-nav .nav-link {
        padding: 0.75rem 1rem !important;
    }

    .premium-link, .donate-link {
        margin: 0.25rem 0;
        justify-content: center;
    }

    .user-dropdown {
        min-width: 250px;
    }
}
</style>