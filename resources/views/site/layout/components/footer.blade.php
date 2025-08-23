<footer class="container-fluid no-left-padding no-right-padding footer-main footer-section1">
	<!-- <div class="container-fluid no-left-padding no-right-padding subscribe-block">
		<div class="container">
			<h3>Subscribe</h3>
			<p>Subscribe to a newsletter to receive latest post and updates</p>
			<form class="newsletter">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="enter your email address here">
					<span class="input-group-btn">
						<button class="btn btn-secondary" type="button">subscribe</button>
					</span>
				</div>
			</form>
		</div>
	</div> -->
	<!-- Container -->
	<?php $social_footer = \Helpers::getSocialMedias(0);?>
	<div class="container">
		<ul class="ftr-social">
			@if(isset($social_footer) && count($social_footer))
				@foreach($social_footer as $social_footer_data)
					<li><a target="_blank" href="{{$social_footer_data->url}}" title="{{$social_footer_data->name}}"><i class="fa {{$social_footer_data->icon}}"></i>{{$social_footer_data->name}}</a></li>
				@endforeach
			@endif
			<!-- <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i>Facebook</a></li>
			<li><a href="#" title="Twitter"><i class="fa fa-twitter"></i>twitter</a></li>
			<li><a href="#" title="Instagram"><i class="fa fa-instagram"></i>Instagram</a></li>
			<li><a href="#" title="Google Plus"><i class="fa fa-google-plus"></i>Google plus</a></li>
			<li><a href="#" title="Pinterest"><i class="fa fa-pinterest-p"></i>pinterest</a></li>
			<li><a href="#" title="Youtube"><i class="fa fa-youtube"></i>youtube</a></li> -->
		</ul>
		<div class="copyright ">
			<p style="float:left;">{{__('lang.website_copyright')}} {{date('Y')}} {{setting('site_name')}}. {{setting('powered_by')}}</p>
			<p style="float:right;">
				<ul>
					@php $cmsList = \Helpers::getCmsForSite(); @endphp
					@if(isset($cmsList) && count($cmsList))
						@foreach($cmsList as $cms)
							<li class="footer-list-style"><a class="anchor-color" href="{{url('/'.$cms->page_title)}}">{{$cms->title}}</a></li>
						@endforeach
					@endif
				</ul>
			</p>
		</div>
	</div><!-- Container /- -->
</footer><!-- Footer Main /- -->