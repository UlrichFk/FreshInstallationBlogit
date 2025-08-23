@extends('admin/layout/app')

@section('content')
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/pages/page-auth.css')}}"/>
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
            <h3 class="mb-1 fw-bold">{{__('lang.admin_reset_password')}}</h3>
            <p class="mb-4">{{__('lang.admin_reset_password_sub_text')}}</p>

            <form id="formAuthentication" class="mb-3" action="{{ url('/do-admin-reset-password') }}" method="POST">
            @csrf
              <div class="mb-3">
                  <label for="otp" class="form-label">{{__('lang.admin_otp')}}</label>
                  <input
                    type="text"
                    id="otp"
                    class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" required autocomplete="otp" autofocus
                    placeholder="{{__('lang.admin_otp_placeholder')}}"
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">{{__('lang.admin_password')}}</label>
                    
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer" id="toggle-password"><i id="password-icon" class="ti ti-eye-off"></i></span>
                  </div>
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">{{__('lang.admin_cpassword')}}</label>
                    
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      id="cpassword" type="cpassword" class="form-control @error('v') is-invalid @enderror" name="cpassword" required autocomplete="cpassword"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="cpassword"
                    />
                    <span class="input-group-text cursor-pointer" id="toggle-cpassword"><i id="cpassword-icon" class="ti ti-eye-off"></i></span>
                  </div>
                </div>
              <button class="btn btn-primary d-grid w-100" type="submit">{{__('lang.admin_reset')}}</button>
            </form>
            <div class="text-center">
                <a href="{{url('admin-login')}}" class="d-flex align-items-center justify-content-center">
                  <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                  {{__('lang.admin_back_to_login')}}
                </a>
            </div> 
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
<!-- <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <div class="card">
            <div class="card-body">
              <div class="app-brand justify-content-center mb-4 mt-2">
                <a href="{{url('/')}}" class="app-brand-link gap-2">
                  <span class="app-brand-text demo text-body fw-bold ms-1">Incite</span>
                </a>
              </div>
              <h4 class="mb-1 pt-2">{{__('lang.admin_reset_password')}}</h4>
              <p class="mb-4">{{__('lang.admin_reset_password_sub_text')}}</p>

              <form id="formAuthentication" class="mb-3" action="{{ url('/do-admin-reset-password') }}" method="POST">
              @csrf
                <div class="mb-3">
                  <label for="otp" class="form-label">{{__('lang.admin_otp')}}</label>
                  <input
                    type="text"
                    id="otp"
                    class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" required autocomplete="otp" autofocus
                    placeholder="{{__('lang.admin_otp_placeholder')}}"
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">{{__('lang.admin_password')}}</label>
                    
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer" id="toggle-password"><i id="password-icon" class="ti ti-eye-off"></i></span>
                  </div>
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">{{__('lang.admin_cpassword')}}</label>
                    
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      id="cpassword" type="cpassword" class="form-control @error('v') is-invalid @enderror" name="cpassword" required autocomplete="cpassword"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="cpassword"
                    />
                    <span class="input-group-text cursor-pointer" id="toggle-cpassword"><i id="cpassword-icon" class="ti ti-eye-off"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">{{__('lang.admin_reset')}}</button>
                </div>
              </form>
              <div class="text-center">
                <a href="{{url('admin-login')}}" class="d-flex align-items-center justify-content-center">
                  <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                  {{__('lang.admin_back_to_login')}}
                </a>
              </div>  
            </div>
          </div>
        </div>
      </div>
    </div> -->
    @endsection