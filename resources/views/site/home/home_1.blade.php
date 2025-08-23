@extends('site/layout/site-app')
@section('content')

<style>
.type-post .entry-cover .post-meta > span.post-date {
    margin-right: 35px;
}
</style>

<div class="main-container">
	<main class="site-main">
		@if(isset($slider) && count($slider))
			<div class="container-fluid no-left-padding no-right-padding slider-section slider-section6">
				<div class="slider-carousel slider-carousel-6 center">					
					@foreach($slider as $slider_data)
					<div class="item">
						<div class="post-box">
							@if($slider_data->image!='')
								<img src="{{ url('uploads/blog/768x428/'.$slider_data->image->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-slider.png') }}`;" alt="{{$slider_data->title}}" />
							@else
								<img src="{{ asset('site-assets/img/1920x982.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-slider.png') }}`;" alt="{{$slider_data->title}}" / style="max-height: 240px;">
							@endif
							<div class="entry-content">
								<span class="post-category">
								@if(isset($slider_data->blog_categories) && $slider_data->blog_categories!='')
									@if(isset($slider_data->blog_categories->category) && $slider_data->blog_categories->category!='')	
										<a href="{{url('category/'.$slider_data->blog_categories->category->slug)}}" title="{{$slider_data->blog_categories->category->name}}">{{$slider_data->blog_categories->category->name}}</a>
									@endif
								@endif	
								</span>
								<h3><a href="{{url('blog/'.$slider_data->slug)}}" title="{{$slider_data->title}}">{{\Helpers::getLimitedTitleSlider($slider_data->title)}}</a></h3>
								<a href="{{url('blog/'.$slider_data->slug)}}" title="{{__('lang.website_read_more')}}">{{__('lang.website_read_more')}}</a>
							</div>
						</div>
					</div>
					@endforeach					
				</div>
			</div>
		@endif	
		@if(isset($trending) && count($trending))
			<div class="container-fluid no-left-padding no-right-padding trending-section">
				<div class="container">
					<div class="section-header">
						<h3>{{__('lang.website_trending')}}</h3>
					</div>
					<div class="trending-carousel">						
						@foreach($trending as $trending_data)
							<div class="type-post">
								<div class="entry-cover">
									<a href="{{url('blog/'.$trending_data->slug)}}">
										@if($trending_data->image!='')
											<img src="{{ url('uploads/blog/327x250/'.$trending_data->image->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-trending.png') }}`;" alt="{{$trending_data->title}}" />
										@else
											<img src="{{ asset('site-assets/img/1920x982.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-trending.png') }}`;" alt="{{$trending_data->title}}" />
										@endif
									</a>
								</div>
								<div class="entry-content">
									<div class="entry-header">
										<span>
										@if(isset($trending_data->blog_categories) && $trending_data->blog_categories!='')
											@if(isset($trending_data->blog_categories->category) && $trending_data->blog_categories->category!='')	
												<a href="{{url('category/'.$trending_data->blog_categories->category->slug)}}" title="{{$trending_data->blog_categories->category->name}}">{{$trending_data->blog_categories->category->name}}</a>
											@endif
										@endif	
										</span>
										<h3 class="entry-title"><a href="{{url('blog/'.$trending_data->slug)}}" title="{{$trending_data->title}}">{{\Helpers::getLimitedTitle($trending_data->title)}}</a></h3>
									</div>
								</div>
							</div>
						@endforeach						
					</div>
				</div>
			</div>
		@endif
		<div class="container-fluid no-left-padding no-right-padding page-content mt-5">
			<div class="container">
				<div class="row">
					@if(isset($latest) && count($latest))
						<div class="col-lg-9 col-md-6 content-area">
							<div class="row loadList">								
								@foreach($latest as $latest_data)
									<div class="col-lg-6 col-md-12 col-sm-6">
										<div class="type-post">
											<div class="entry-cover">
												<div class="post-meta">
													<span class="byline">
														@if(Auth::user()!='')
															<a href="javascript:;" onclick="addRemoveBookMarks('{{$latest_data->id}}','latest');" title="{{__('lang.website_save_post')}}">
																<i class="fa fa-bookmark-o notmarked_{{$latest_data->id}} hide"></i>
																<i class="fa fa-bookmark marked_{{$latest_data->id}} hide"></i>
																@if($latest_data->blog_bookmark==0)
																	<i class="fa fa-bookmark-o notmarked_{{$latest_data->id}}"></i>
																@else
																	<i class="fa fa-bookmark marked_{{$latest_data->id}}"></i>
																@endif
															</a>														
														@endif
													</span>
													<span class="post-date">{{date('M d, Y',strtotime($latest_data->schedule_date))}}</span>
												</div>
												<a href="{{url('blog/'.$latest_data->slug)}}">
													@if($latest_data->image!='')
														<img src="{{ url('uploads/blog/327x250/'.$latest_data->image->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$latest_data->title}}" />
													@else
														<img src="{{ asset('site-assets/img/1920x982.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$latest_data->title}}" />
													@endif
												</a>
											</div>
											<div class="entry-content">
												<div class="entry-header">	
													<span class="post-category">
													@if(isset($latest_data->blog_categories) && $latest_data->blog_categories!='')
														@if(isset($latest_data->blog_categories->category) && $latest_data->blog_categories->category!='')	
															<a href="{{url('category/'.$latest_data->blog_categories->category->slug)}}" title="{{$latest_data->blog_categories->category->name}}">{{$latest_data->blog_categories->category->name}}</a>
														@endif
													@endif	
													</span>
													<h3 class="entry-title"><a href="{{url('blog/'.$latest_data->slug)}}" title="{{$latest_data->title}}">{{\Helpers::getLimitedTitle($latest_data->title)}}</a></h3>
												</div>								
												<p><?php echo \Helpers::getLimitedDescription($latest_data->description);?></p>
												<a href="{{url('blog/'.$latest_data->slug)}}" title="{{__('lang.website_read_more')}}">{{__('lang.website_read_more')}}</a>
											</div>
										</div>
									</div>
								@endforeach									
							</div>
						</div>
					@endif
					<div class="col-lg-3 col-md-6 widget-area">
						@include('site/home/partials/popular') 
						@include('site/home/partials/category_sidebar') 
						@include('site/home/partials/trending_sidebar') 
						@include('site/home/partials/follow_us') 
					</div>
				</div>
			</div>
		</div>
	</main>
</div>
@endsection