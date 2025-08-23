<?php $categories_header = \Helpers::getCategoryForSite(0);?>
<header class="container-fluid no-left-padding no-right-padding header_s header-fix header_s3">
		<!-- Menu Block -->
		<div class="container-fluid no-left-padding no-right-padding menu-block">
			<!-- Container -->
			<div class="container">				
				<nav class="navbar ownavigation navbar-expand-lg">
					<a class="navbar-brand" href="{{url('/')}}" style="margin: 0px 0 0px;">
						<img src="{{ url('uploads/setting/'.setting('site_logo'))}}" alt="{[setting('site_name')]}" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-logo-image.png') }}`" style="width: 200px;"/>
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
										<!-- <li><a class="dropdown-item" href="{{url('category/1/10')}}" title="Subcategory 1">Subcategory 2</a></li>
										<li><a class="dropdown-item" href="{{url('category/1/10')}}" title="Subcategory 1">Subcategory 3</a></li>
										<li><a class="dropdown-item" href="{{url('category/1/10')}}" title="Subcategory 1">Subcategory 4</a></li>
										<li><a class="dropdown-item" href="{{url('category/1/10')}}" title="Subcategory 1">Subcategory 5</a></li> -->
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
									<!-- <li><a class="dropdown-item" href="{{url('category/1/10')}}" title="Subcategory 1">Subcategory 1</a></li>
                                    <li><a class="dropdown-item" href="{{url('category/1/10')}}" title="Subcategory 1">Subcategory 2</a></li>
                                    <li><a class="dropdown-item" href="{{url('category/1/10')}}" title="Subcategory 1">Subcategory 3</a></li>
                                    <li><a class="dropdown-item" href="{{url('category/1/10')}}" title="Subcategory 1">Subcategory 4</a></li>
                                    <li><a class="dropdown-item" href="{{url('category/1/10')}}" title="Subcategory 1">Subcategory 5</a></li> -->
								</ul>
							</li>
							@endif
							@endif
							<!-- <li class="dropdown">
								<i class="ddl-switch fa fa-angle-down"></i>
								<a class="nav-link dropdown-toggle" title="Pages" href="#">Pages</a>
								<ul class="dropdown-menu">
									<li><a class="dropdown-item" href="header-page.html" title="Header">Header</a></li>
									<li><a class="dropdown-item" href="footer-page.html" title="Footer">Footer</a></li>
									<li><a class="dropdown-item" href="404.html" title="404">404</a></li>
								</ul>
							</li>
							<li><a class="nav-link" title="Features" href="#">Features</a></li>
							<li><a class="nav-link" title="Archives" href="#">Archives</a></li>
							<li class="dropdown">
								<i class="ddl-switch fa fa-angle-down"></i>
								<a class="nav-link dropdown-toggle" title="About Us" href="aboutus.html">About Us</a>
								<ul class="dropdown-menu">
									<li><a class="dropdown-item" href="aboutus_fullwidth.html" title="About Us No sidebar">About Us No sidebar</a></li>
									<li><a class="dropdown-item" href="aboutme.html" title="About Me">About Me</a></li>
									<li><a class="dropdown-item" href="aboutme_fullwidth.html" title="About Me No sidebar">About Me No sidebar</a></li>
								</ul>
							</li> -->
							<li><a class="nav-link" title="{{__('lang.website_all_blogs')}}" href="{{url('all-blogs')}}">{{__('lang.website_all_blogs')}}</a></li>
							<!-- <li><a class="nav-link" title="Contact" href="{{url('about-us')}}">About Us</a></li>
							<li><a class="nav-link" title="Contact" href="{{url('contact-us')}}">Contact</a></li> -->
						</ul>
					</div>
					<ul class="user-info">
						<li><a href="#search-box" data-toggle="collapse" class="search collapsed" title="Search"><i class="pe-7s-search sr-ic-open"></i><i class="pe-7s-close sr-ic-close"></i></a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" href="#"><i class="pe-7s-user"></i></a>
							<ul class="dropdown-menu">
								@if(Auth::user()!='')
									<li><a class="dropdown-item" href="{{url('profile')}}" title="{{__('lang.website_my_profile')}}">{{__('lang.website_my_profile')}}</a></li>
									<li><a class="dropdown-item" href="{{url('saved-stories')}}" title="{{__('lang.website_saved_stories')}}">{{__('lang.website_saved_stories')}}</a></li>
									<li><a class="dropdown-item" href="{{url('logout')}}" title="{{__('lang.website_logout')}}">{{__('lang.website_logout')}}</a></li>
								@else
									<li><a class="dropdown-item" href="{{url('login')}}" title="{{__('lang.website_signin')}}">{{__('lang.website_signin')}}</a></li>
									<li><a class="dropdown-item" href="{{url('signup')}}" title="{{__('lang.website_signup')}}">{{__('lang.website_signup')}}</a></li>
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
						<input type="text" class="form-control" placeholder="Search..." name="keyword" required>
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