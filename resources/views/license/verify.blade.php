<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{asset('/admin-assets/')}}" data-template="vertical-menu-template">
    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
      <title>{{setting('site_seo_title')}}</title>
      <meta name="description" content="" />
      <link rel="icon" type="image/x-icon" href="{{url('uploads/setting/'.setting('site_favicon'))}}" />
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />    
      <script>
          var base_url = "{{url('')}}";
      </script>
      <link rel="stylesheet" href="{{ asset('admin-assets/font/font.css')}}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/fonts/icons.css')}}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/rtl/theme.css')}}" id="theme-style" />
      <link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css')}}"/>
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/toastr/toastr.css')}}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/animate-css/animate.css')}}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/pages/page-auth.css')}}"/>
      <script src="{{ asset('admin-assets/vendor/js/helpers.js')}}"></script>
      <script src="{{ asset('admin-assets/js/config.js')}}"></script>
    </head>
    <body> 
        <div class="container-xxl">
            <div class="authentication-wrapper authentication-cover authentication-bg">
                <div class="authentication-inner row">
                    <!-- /Left Text -->
                    <div class="d-none d-lg-flex col-lg-7 p-0">
                    <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                        @if(isset($_COOKIE['theme'])) 
                        @if($_COOKIE['theme']=='dark')
                        <img
                        src="{{ asset('admin-assets/img/illustrations/auth-login-illustration-dark.png')}}"
                        alt="auth-login-cover"
                        class="img-fluid my-5 auth-illustration"
                        
                        data-app-light-img="{{ asset('admin-assets/img/illustrations/auth-login-illustration-light.png')}}"
                        data-app-dark-img="{{ asset('admin-assets/img/illustrations/auth-login-illustration-dark.png')}}"
                        />

                        <img
                        src="{{ asset('admin-assets/img/illustrations/bg-shape-image-dark.png')}}"
                        alt="auth-login-cover"
                        class="platform-bg"
                        data-app-light-img="{{ asset('admin-assets/img/illustrations/bg-shape-image-light.png')}}"
                        data-app-dark-img="{{ asset('admin-assets/img/illustrations/bg-shape-image-dark.png')}}"
                        />
                        @else
                        <img
                        src="{{ asset('admin-assets/img/illustrations/auth-login-illustration-light.png')}}"
                        alt="auth-login-cover"
                        class="img-fluid my-5 auth-illustration"
                        
                        data-app-light-img="{{ asset('admin-assets/img/illustrations/auth-login-illustration-light.png')}}"
                        data-app-dark-img="{{ asset('admin-assets/img/illustrations/auth-login-illustration-dark.png')}}"
                        />

                        <img
                        src="{{ asset('admin-assets/img/illustrations/bg-shape-image-light.png')}}"
                        alt="auth-login-cover"
                        class="platform-bg"
                        data-app-light-img="{{ asset('admin-assets/img/illustrations/bg-shape-image-light.png')}}"
                        data-app-dark-img="{{ asset('admin-assets/img/illustrations/bg-shape-image-dark.png')}}"
                        />

                        @endif
                        @else
                        <img
                        src="{{ asset('admin-assets/img/illustrations/auth-login-illustration-light.png')}}"
                        alt="auth-login-cover"
                        class="img-fluid my-5 auth-illustration"
                        
                        data-app-light-img="{{ asset('admin-assets/img/illustrations/auth-login-illustration-light.png')}}"
                        data-app-dark-img="{{ asset('admin-assets/img/illustrations/auth-login-illustration-dark.png')}}"
                        />

                        <img
                        src="{{ asset('admin-assets/img/illustrations/bg-shape-image-light.png')}}"
                        alt="auth-login-cover"
                        class="platform-bg"
                        data-app-light-img="{{ asset('admin-assets/img/illustrations/bg-shape-image-light.png')}}"
                        data-app-dark-img="{{ asset('admin-assets/img/illustrations/bg-shape-image-dark.png')}}"
                        />
                        @endif
                    </div>
                    </div>
                    <!-- /Left Text -->

                    <!-- Login -->
                    <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                    <div class="w-px-400 mx-auto">
                        <!-- Logo -->
                        <div class="app-brand mb-4">
                            <a href="{{url('/admin-login')}}" class="app-brand-link gap-2">
                            <img class="width-45-percent" src="{{url('uploads/setting/'.setting('website_admin_logo'))}}" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-logo-image.png') }}`"/>
                            </a>             
                        </div>
                        <!-- /Logo -->
                        @if(env('CODE_VERIFIED')==true)
                        <!-- <h3 class="mb-1 fw-bold">{{__('lang.admin_login')}}</h3>
                        <p class="mb-4">{{__('lang.admin_login_sub_text')}}</p> -->
                            <h4 class="mb-1 pt-2">{{__('messages.thank_you')}}</h4>
                            <p>{{__('messages.code_verified_success')}}</p>
                            <p class="mb-4">{{__('messages.use_credentials')}}</p>
                            <p class="">
                                {{__('messages.username')}} : <span id="username">admin@gmail.com</span>
                                <i class="menu-icon tf-icons ti ti-copy copy-button" data-clipboard-target="#username" style="cursor: pointer;"></i>
                            </p>
                            <p class="">
                                {{__('messages.password')}} : <span id="password">admin</span>
                                <i class="menu-icon tf-icons ti ti-copy copy-button" data-clipboard-target="#password" style="cursor: pointer;"></i>
                            </p>
                            <a class="btn btn-primary d-grid w-100" href="{{url('/admin-login')}}">{{__('messages.go_to_admin_panel')}}</a>
                        @else
                            <h4 class="mb-1 pt-2">{{__('messages.verify_purchase_code')}}</h4>
                            <small>{{__('messages.enter_purchase_code')}}</small>
                            <p class="mb-4"></p>
                            <form id="formAuthentication" class="mb-3"  action="{{ route('license.verify') }}" method="POST" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="purchase_code" class="form-label">{{__('messages.purchase_code')}}</label>
                                    <input
                                        type="text"
                                        id="purchase_code" 
                                        name="purchase_code"
                                        class="form-control @error('purchase_code') is-invalid @enderror" value="{{ old('purchase_code') }}" required autocomplete="purchase_code" autofocus
                                        placeholder="{{__('messages.enter_purchase_code_placeholder')}}"
                                    />
                                 <input type="hidden" name="base_url" value="{{ url('/') }}">
                                </div>
                                <button class="btn btn-primary d-grid w-100" type="submit">{{__('messages.verify')}}</button>
                            </form>
                        @endif
                        
                    </div>
                    </div>
                    <!-- /Login -->
                </div>
                </div>
        </div>
        <script src="{{ asset('admin-assets/vendor/libs/jquery/jquery.js')}}"></script>
        <script src="{{ asset('admin-assets/vendor/js/bootstrap.js')}}"></script>
        <script src="{{ asset('admin-assets/vendor/js/menu.js')}}"></script>
        <script src="{{ asset('admin-assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
        <script src="{{ asset('admin-assets/vendor/libs/swiper/swiper.js')}}"></script>
        <script src="{{ asset('admin-assets/vendor/libs/toastr/toastr.js')}}"></script>
        <script src="{{ asset('admin-assets/js/main.js')}}"></script>
        <script src="{{ asset('admin-assets/js/dashboards-analytics.js')}}"></script>
        <script src="{{ asset('admin-assets/js/theme.js')}}"></script>
        <script src="{{ asset('admin-assets/js/custom.js')}}"></script>
        <script src="{{ asset('admin-assets/js/ui-toasts.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
        @if(Session::has('error'))
            <script>
                toastr['error']('', "{{ session('error') }}");
            </script>
        @endif
        @if(Session::has('info'))
            <script>
                toastr['info']('', "{{ session('info') }}");
            </script>
        @endif
        @if(Session::has('warning'))
            <script>
                toastr['warning']('', "{{ session('warning') }}");
            </script>
        @endif
        @if(Session::has('success'))
        <script>
            $(document).ready(function() {
                $('#basicModal').modal('show');
            });
        </script>
        @endif
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var clipboard = new ClipboardJS('.copy-button');
                clipboard.on('success', function(e) {
                    e.clearSelection();
                    toastr['success']('', 'Copied to clipboard!');
                });
                clipboard.on('error', function(e) {
                    toastr['error']('', 'Copy failed. Please copy the text manually.');
                });
            });
        </script>
    </body>
</html>