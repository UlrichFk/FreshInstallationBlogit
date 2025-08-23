@extends('site/layout/site-app')

@section('content')
<div class="main-container">	
	<main class="site-main">
		<div class="container-fluid no-left-padding no-right-padding contact-section">		
		</div>
		<div class="container-fluid no-left-padding no-right-padding">
			<div class="container">
				<div class="contact-info">
					<div class="block-title">
						<h3>{{__('lang.website_reset_title')}}</h3>
					</div>
				</div>
				<div class="contact-form">
					<form class="row" id="reset-password" onsubmit="return validatePassword();" action="{{url('/do-reset-password')}}" method="POST">
						@csrf
						<div class="col-md-12 form-group" style="text-align: -webkit-center;">
							<div class="col-md-4 form-group">
								<input type="text" class="form-control" placeholder="{{__('lang.website_otp_placeholder')}}" name="otp" id="otp" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
							</div>
							<div class="col-md-4 form-group">
								<input type="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" name="password" id="password">
							</div>
							<div class="col-md-4 form-group">
								<input type="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" name="cpassword" id="cpassword">
							</div>
							<div class="col-md-4 form-group">
								<button type="submit" class="submit">{{__('lang.website_reset_button')}}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</main>		
</div>
<script type="text/javascript">
function validatePassword() {
  var password = document.getElementById("password").value;
  var cpassword = document.getElementById("cpassword").value;
  var uppercase = /[A-Z]/;
  var lowercase = /[a-z]/;
  var specialChars = /[!@#$%^&*()_+=-{};:'<>,./?]/;

  if (password.length < 8 || !uppercase.test(password) || !lowercase.test(password) || !specialChars.test(password)) {
    toastr.error("Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one special character.");
    return false;
  }

  if (password !== cpassword) {
    toastr.error("Confirm password does not match with password.");
    return false;
  }

  return true;
}
</script>
@endsection