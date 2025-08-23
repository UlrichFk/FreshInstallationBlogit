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
			<!-- Contact-Us Section -->	
			<div class="container-fluid no-left-padding no-right-padding contact-section">		
			</div>
			<!-- Page Content -->
			<div class="container-fluid no-left-padding no-right-padding">
				<!-- Container -->
				<div class="container">
					<div class="contact-info">
						<div class="block-title">
							<h3>{{__('lang.website_my_profile')}}</h3>
						</div>
					</div>
					<div class="contact-form">
						<form class="row" id="user-profile" onsubmit="return validateAlphabeticName() && validateEmail() && validatePhoneNumber() && validatePassword();" action="{{url('/update-profile')}}" method="POST" enctype="multipart/form-data">
							@csrf
                            <input type="hidden" name="id" value="{{$row->id}}">
							<div class="col-md-12 form-group" style="text-align: -webkit-center;">
								<div class="col-md-4 form-group">
									<input type="text" class="form-control" placeholder="{{__('lang.website_name_placeholder')}}" name="name" id="name" value="{{ $row->name }}" required>
								</div>
								<div class="col-md-4 form-group">
									<input type="text" class="form-control" placeholder="{{__('lang.website_email_placeholder')}}" name="email" id="email" value="{{ $row->email }}" required>
								</div>
								<div class="col-md-4 form-group">
									<input type="text" class="form-control"  placeholder="{{__('lang.website_phone_placeholder')}}" name="phone" id="phone" value="{{ $row->phone }}" inputmode="numeric"maxlength="10" required>
								</div>
								<div class="col-md-4 form-group">
							      <input type="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" name="password" id="password">
							      <span class="eye" onclick="togglePassword()">
						                <i class="fa fa-eye-slash" id="eye-icon"></i>
						           </span>
							    </div>
								<div class="col-md-4 form-group">
								<button type="submit" class="submit">{{__('lang.website_update')}}</button>
							    </div>
							</div>
						</form>
					</div>
				</div>
				<!-- Container /- -->
			</div>
			<!-- Page Content /- -->	
		</main>
	</div>

<script>

function validateAlphabeticName() {
  var name = document.getElementById('name').value;
  var nameRegex = /^[a-zA-Z\s]+$/;
  if (!nameRegex.test(name)) {
    toastr.error("Name must contain only alphabetic characters and spaces");
    return false;
  }
  return true;
}
  
function validateEmail() {
  var email = document.getElementById('email').value;
  var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!emailRegex.test(email)) {
    toastr.error("Invalid email format");
    return false;
  }
  return true;
}

function validatePhoneNumber() {
  var phone = document.getElementById('phone').value;
  var phoneRegex = /^\d{10}$/;
  if (!phoneRegex.test(phone)) {
    toastr.error("Phone number must be exactly 10 digits");
    return false;
  }
  return true;
}

function validatePassword() {
	var password = document.getElementById("password").value;
	var uppercase = /[A-Z]/;
	var lowercase = /[a-z]/;
	var specialChars = /[!@#$%^&*()_+=-{};:'<>,./?]/;

	if(password != ''){

	    if (password.length < 8 || !uppercase.test(password) || !lowercase.test(password) || !specialChars.test(password)) {
	    	toastr.error("Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one special character.");
	      return false;
	    }
	}

	return true;
}

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