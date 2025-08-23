<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        @if(Request::segment(1)=='blog')
            <title>{{$row->seo_title}}</title>
            @if($row->author_name!='')
                <meta name="author" content="{{$row->author_name}}">
            @else
                <meta name="author" content="{{setting('site_seo_title')}}">
            @endif
            <meta name="description" content="{{$row->seo_description}}">
            @if($row->seo_keyword!='')
                <meta name="keywords" content="{{$row->seo_keyword}}">
            @else
                <meta name="keywords" content="{{setting('site_seo_keyword')}}">
            @endif
        @else
            @if(isset($row) && $row!='')
                <title>@if(isset($row->meta_char) && $row->meta_char!=''){{$row->meta_char}}@endif</title>
                <meta name="author" content="{{setting('site_seo_title')}}">
                <meta name="description" content="@if(isset($row->meta_desc) && $row->meta_desc!=''){{$row->meta_desc}}@endif">
                <meta name="keywords" content="@if(isset($row->meta_keywords) && $row->meta_keywords!=''){{$row->meta_keywords}}@endif">
            @else
                <title>{{setting('site_seo_title')}}</title>
                <meta name="author" content="{{setting('site_seo_title')}}">
                <meta name="description" content="{{setting('site_seo_description')}}">
                <meta name="keywords" content="{{setting('site_seo_keyword')}}">
            @endif            
        @endif
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if(setting('site_favicon')!='')
        <link rel="icon" type="image/x-icon" href="{{url('uploads/setting/'.setting('site_favicon'))}}" />
        @else
        <link rel="icon" type="image/x-icon" href="{{url('uploads/no-favicon.png')}}" />
        @endif
		<link href="https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700%7cMontserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{ asset('site-assets/revolution/css/settings.css')}}">
		<link href="{{ asset('site-assets/css/lib.css')}}" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{ asset('site-assets/slick/slick.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ asset('site-assets/slick/slick-theme.css')}}">
		<link rel="stylesheet" href="{{ asset('site-assets/css/rtl.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ asset('site-assets/css/style.css')}}">
		<link rel="stylesheet" href="{{ asset('site-assets/css/toastr.min.css')}}" rel="stylesheet" type="text/css">
        <style>
            #overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5); /* Adjust the opacity as needed */
                z-index: 9998; /* Set a z-index lower than the loader */
            }
            #loader {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 9999;
            }
            #loader img {
                width: 50px; /* Adjust the size of the loader image */
            }
            .hide{
                display:none;
            }
            .ftr-social > li {
                display: inline-block;
                margin: 0 15px;
            }
            .footer-list-style{
                list-style: none;
                display: inline-block;
                margin-right: 10px;
                color:#a1a1a1;
            }
            .anchor-color{
                color: #a1a1a1 !important;
            }
        </style>
		<script>
            var base_url = "{{url('')}}";
            window.translations = {
                locale: '{{ app()->getLocale() }}',
                messages: @json(__('lang'))
            };
        </script>
        <?php echo setting('google_analytics_code'); ?>
	</head>
	<body data-offset="200" data-spy="scroll" data-target=".ownavigation">
		<div id="site-loader" class="load-complete">
			<div class="loader">
				<div class="line-scale"><div></div><div></div><div></div><div></div><div></div></div>
			</div>
		</div>
		@include('site/layout/components/header_1') 
			@yield('content')
		@include('site/layout/components/footer')
		<script src="{{ asset('site-assets/js/jquery-1.12.4.min.js')}}"></script>
		<script src="{{ asset('site-assets/js/popper.min.js')}}"></script>
		<script src="{{ asset('site-assets/js/lib.js')}}"></script>
		<script type="text/javascript" src="{{ asset('site-assets/slick/slick.min.js')}}"></script>
		<script src="{{ asset('site-assets/js/functions.js')}}"></script>
		<script src="{{ asset('site-assets/js/toastr.min.js')}}"></script>
		<script src="{{ asset('site-assets/js/validation.js')}}"></script>
		<script src="{{ asset('site-assets/js/script.js')}}"></script>
		<script>        
			<?php if(Session::has('success')){ ?>
				toastr.success("<?php echo Session::get('success'); ?>");
			<?php }else if(Session::has('error')){  ?>
				toastr.error("<?php echo Session::get('error'); ?>");
			<?php } ?>
        </script>
		<script>
            var page_name = "home";
            var category_name = ""; 
        </script>
        <?php if(Request::segment(1)==''){ ?>
            <script> page_name = "home"; </script>
            <?php }else if(Request::segment(1)=='category'){ ?>
                <script> page_name = "category";
                category_name = "<?php echo Request::segment(2); ?>";</script>
            <?php }else if(Request::segment(3)!=''){ ?>
                <script> page_name = "subcategory";
                category_name = "<?php echo Request::segment(3); ?>";</script>
            <?php }else if(Request::segment(1)=='all-blogs'){ ?>
                <script>page_name = "allblogs";</script>
        <?php }?>
        <?php if(isset($show_pagination) && $show_pagination==1){ 
            if(Request::segment(1)=='' || Request::segment(1)=='category' || Request::segment(1)=='all-blogs'){ ?>
            <script>
                var page = 1;
                var scrollThreshold = 500; 
                var scrollMore = 0; 
                $(document).ready(function () {
                    $(window).scroll(function () {
                        if ($(document).height() - $(window).height() - $(window).scrollTop() <= scrollThreshold) {
                            if(scrollMore!=1){
                                page++;
                                fetchPosts(page);
                            }                        
                        }
                    });
                });
                function fetchPosts(page) {
                    $('#site-loader').show();
                    $(".load-complete").css('background-color','rgba(0, 0, 0, 0.5)');
                    $.ajax({
                        url: base_url+'/fetch?page=' + page +'&page_name='+page_name+'&category='+category_name,
                        type: 'get',
                        success: function (data) {                   
                            if (data.html == "") {
                                scrollMore = 1;
                                // No more posts to load
                            } else {
                                $('.loadList').append(data.html);
                            }                       
                        },
                        complete: function() {
                            // $(".load-complete").css('background-color','#ffffff');
                            $('#site-loader').hide(); // Hide the loader image when the request is complete
                        }
                    });
                }
            </script>
        <?php } } ?>
	</body>
    <script>
        $(document).ready(function() {
          $('a.search').on('click', function() {
            setTimeout(function() {
              $('#search-box input[type="text"]').focus();
            }, 100);
          });
        });
    </script>
</html>