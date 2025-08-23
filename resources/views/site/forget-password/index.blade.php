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
						<h3>{{__('lang.website_forget_title')}}</h3>
					</div>
				</div>
				<div class="contact-form">
					<form class="row" id="user-forget-password" onsubmit="return validateForgetPassword('user-forget-password');" action="{{url('/do-forget-password')}}" method="POST">
						@csrf
						<div class="col-md-12 form-group" style="text-align: -webkit-center;">
							<div class="col-md-4 form-group">
								<input type="email" class="form-control" placeholder="{{__('lang.website_email_placeholder')}}" name="email" id="email" required>
							</div>
							<div class="col-md-4 form-group" style="text-align:left;">
								<a href="{{url('/login')}}">{{__('lang.website_login_title')}}</a>
							</div>
							<div class="col-md-4 form-group">
								<button type="submit" class="submit">{{__('lang.website_forget_button')}}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</main>		
</div>
@endsection