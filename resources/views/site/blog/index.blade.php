@extends('site/layout/site-app')
@section('content')
<div class="main-container">	
	<main class="site-main">	
		<div class="container-fluid no-left-padding no-right-padding 	">
			<div class="container">
				<div class="block-title">
					<h3>{{$category->name}}</h3>
				</div>
				<div class="row">
					<div class="col-lg-8 col-md-6 content-area">
						<div class="row loadList">
							@if(isset($result) && count($result))
								@foreach($result as $row)
									<div class="col-lg-6 col-md-12 col-sm-6">
										<div class="type-post">
											<div class="entry-cover">
												<div class="post-meta">
													<span class="byline">
														@if(Auth::user()!='')
															<a href="javascript:;" onclick="addRemoveBookMarks('{{$row->id}}','category');" title="{{__('lang.website_save_post')}}">					
																@if($row->blog_bookmark==0)
																   <i class="fa fa-bookmark marked_{{$row->id}} hide"></i>
																	<i class="fa fa-bookmark-o notmarked_{{$row->id}}"></i>
																@else
                                                                    <i class="fa fa-bookmark-o notmarked_{{$row->id}} hide"></i>
																	<i class="fa fa-bookmark marked_{{$row->id}}"></i>
																@endif
															</a>														
														@endif
													</span>
													<span class="post-date"><a href="#"><?php echo \Helpers::showSiteDateFormat($row->schedule_date);?></a></span>
												</div>
												@if(Request::segment(3)!='')
													<a href="{{url('blog/'.$row->slug.'?type=category&category_id='.$main_category->id)}}">
												@else
													<a href="{{url('blog/'.$row->slug.'?type=category&category_id='.$category->id)}}">
												@endif												
													@if($row->image!='')
														<img src="{{ url('uploads/blog/327x250/'.$row->image->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$row->title}}" />
													@else
														<img src="{{ asset('site-assets/img/1920x982.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$row->title}}" />
													@endif
												</a>
											</div>
											<div class="entry-content">
												<div class="entry-header">	
													<span class="post-category">
													@if(isset($row->blog_categories) && $row->blog_categories!='')
														@if(isset($row->blog_categories->category) && $row->blog_categories->category!='')	
															<a href="{{url('category/'.$row->blog_categories->category->slug)}}" title="{{$row->blog_categories->category->name}}">{{$row->blog_categories->category->name}}</a>
														@endif
													@endif	
													</span>
													<h3 class="entry-title">
														@if(Request::segment(3)!='')
															<a href="{{url('blog/'.$row->slug.'?type=category&category_id='.$main_category->id)}}" title="{{$row->title}}">{{\Helpers::getLimitedTitle($row->title)}}</a>
														@else
															<a href="{{url('blog/'.$row->slug.'?type=category&category_id='.$category->id)}}" title="{{$row->title}}">{{\Helpers::getLimitedTitle($row->title)}}</a>
														@endif
														
													</h3>
												</div>								
												<p><?php echo \Helpers::getLimitedDescription($row->description);?></p>
												<a href="{{url('blog/'.$row->slug)}}" title="{{__('lang.website_read_more')}}">{{__('lang.website_read_more')}}</a>
											</div>
										</div>
									</div>
								@endforeach	
							@endif
						</div>
					</div>
					<div class="col-lg-4 col-md-6 widget-area">
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