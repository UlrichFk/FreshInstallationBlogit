@extends('site/layout/site-app')

@section('content')
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
							<h3>Contact Us</h3>
						</div>
						<p>These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted.</p>
					</div>
					<div class="contact-form">
						<form class="row">
							<div class="col-md-6 form-group">
								<input type="text" class="form-control" placeholder="Your Name (required)" name="contact-name" id="input_name" required>
							</div>
							<div class="col-md-6 form-group">
								<input type="text" class="form-control" placeholder="Your Email (required)" name="contact-email" id="input_email" required>
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" placeholder="Subject" name="contact-subject" id="input_subject">
							</div>
							<div class="col-md-12 form-group">
								<textarea class="form-control" placeholder="Your message..." rows="5" name="textarea-message" id="textarea_message"></textarea>
							</div>
							<div class="col-md-12 form-group">
								<button id="btn_submit" name="submit" class="submit">Send</button>
							</div>
							<div id="alert-msg" class="alert-msg"></div>
						</form>
					</div>
				</div><!-- Container /- -->
			</div><!-- Page Content /- -->	
		</main>
		
	</div>
@endsection