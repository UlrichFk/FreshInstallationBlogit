@extends('site/layout/site-app')
@section('content')
<style type="text/css">
.eye {
    position: absolute;
    right: 20px;
    top: 55%;
    transform: translateY(-50%);
    cursor: pointer;
}

.fa-eye{
    font-size: 18px;
    color: #666;
}

.fa-eye-slash {
    font-size: 18px;
    color: #666;
}
</style>
<div class="main-container">
	<main class="site-main">	
		<div class="container-fluid no-left-padding no-right-padding contact-section">		
		</div>
		<div class="container-fluid no-left-padding no-right-padding">
			<div class="container">
				<div class="contact-info">
					<div class="block-title">
						<h3>{{__('lang.website_login_title')}}</h3>
					</div>
				</div>
				<div class="contact-form">
					<form class="row" id="user-login" onsubmit="return validateLogin('user-login');" action="{{url('/do-user-login')}}" method="POST">
						@csrf
						<div class="col-md-12 form-group" style="text-align: -webkit-center;">
							<div class="col-md-4 form-group">
								<input type="email" class="form-control" placeholder="{{__('lang.website_email_placeholder')}}" name="email" id="email">
							</div>
							<div class="col-md-4 form-group">
								<input type="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" name="password" id="password">
								<span class="eye" onclick="togglePassword()">
					                <i class="fa fa-eye-slash" id="eye-icon"></i>
					            </span>
							</div>
							<div class="col-md-4 form-group" style="text-align: left;width: 100%;margin-bottom: 2rem;">
								<a href="{{url('/forget-password')}}" style="float:left;">{{__('lang.website_forget_title')}}</a>
								<a href="{{url('/signup')}}" style="float:right;">{{__('lang.website_signup_title')}}</a>
							</div>
							<div class="col-md-4 form-group">
								<button type="submit" class="submit">{{__('lang.website_login_button')}}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</main>
</div>
<script>
function togglePassword() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.getElementById("eye-icon");
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.className = "fa fa-eye";
    } else {
        passwordInput.type = "password";
        eyeIcon.className = "fa fa-eye-slash";
    }
}
</script>
@endsection