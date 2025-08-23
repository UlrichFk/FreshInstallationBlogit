@extends('site/layout/site-app')
@section('content')
<style type="text/css">
	#comment {
	  border: none;
	}

	#comment:focus {
	  border: 1px solid black;
	}
	iframe {
        min-width: 770px;
        height: 300px;
    }
    .source-details{
        font-size: 18px;
    }
    
    .source-details-a{
        text-decoration: underline;
    }
</style>
<div class="main-container mt-3">	
	<main class="site-main">
		<div class="container-fluid no-left-padding no-right-padding page-content blog-single cover-container">
			<div class="container">				
				<div class="row">
					<div class="col-xl-8 col-lg-8 col-md-6 col-12 content-area">
						<div class="entry-cover">	
							@if($row->image!='')
								<img src="{{ url('uploads/blog/768x428/'.$row->image->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$row->title}}" style="width: 100%;" />
							@else
								<img src="{{ asset('site-assets/img/1920x982.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$row->title}}" style="    width: 100%;" />
							@endif					
						</div>
						<article class="type-post">
							<div class="entry-content" style="width: 100%;">
								<div class="entry-header">	
									<span class="post-category">
									@if(isset($row->blog_categories) && $row->blog_categories!='')
										@if(isset($row->blog_categories->category) && $row->blog_categories->category!='')	
											<a href="{{url('category/'.$row->blog_categories->category->slug)}}" title="{{$row->blog_categories->category->name}}">{{$row->blog_categories->category->name}}</a>
										@endif
									@endif	
									</span>
									<h3 class="entry-title">{{$row->title}}</h3>
									<div class="post-meta">
										<span class="post-date" style="margin-right: 10px;"><?php echo \Helpers::showSiteDateFormat($row->schedule_date);?></span>
										@if(Auth::user()!='')
											<a href="javascript:;" onclick="addRemoveBookMarks('{{$row->id}}','detail');" title="{{__('lang.website_save_post')}}">
												@if($row->blog_bookmark==0)
												    <i class="fa fa-bookmark marked hide"></i>
													<i class="fa fa-bookmark-o notmarked"></i>
												@else
												    <i class="fa fa-bookmark-o notmarked hide"></i>
													<i class="fa fa-bookmark marked"></i>
												@endif
											</a>															
										@endif
									</div>
								</div>
							    <div class="entry-cover mt-4">
        						    <?php
                                        function convertToEmbedUrl($url) {
                                            $parsedUrl = parse_url($url);
                                            
                                            if (isset($parsedUrl['host']) && $parsedUrl['host'] === 'www.youtube.com' && isset($parsedUrl['query'])) {
                                                parse_str($parsedUrl['query'], $queryParams);
                                                
                                                if (isset($queryParams['v'])) {
                                                    return 'https://www.youtube.com/embed/' . $queryParams['v'];
                                                } else {
                                                    return false;
                                                }
                                            } else {
                                                return false;
                                            }
                                        }
                                    
                                        $youtubeUrl = $row->video_url;
                                        $embedUrl = convertToEmbedUrl($youtubeUrl);
                                    ?>
                                        
                                    @if($embedUrl)
                                    <iframe style="min-width: 770px;height: 400px" src="{{$embedUrl}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    @endif
        						</div>
								<p><?php echo $row->description; ?></p>
								@if($row->source_name !='')
								<p> <span class="source-details">Source :</span> <span><a class="source-details-a" target="_blank" href="{{$row->source_link}}">{{$row->source_name}}</a> </span></p>
								@endif
								<div class="entry-footer">
									<div class="tags">
										@if($row->tags!='')
											@foreach($row->tags as $tags)
												<a href="{{url('search-blog?keyword='.$tags)}}" title="{{$tags}}"># {{$tags}}</a>
											@endforeach
										@endif
									</div>
								</div>
								@if(isset($previous_blog) && $previous_blog!='')
								    <div class="postnav_left">
								        <div class="single_post_arrow_content">
								            <a href="{{ url('blog/'.$previous_blog->slug) }}{{ request()->getQueryString() ? '?'.request()->getQueryString() : '' }}" id="prepost">
								                {{ \Helpers::getNextPreviousLimitedTitle($previous_blog->title) }} 
								                <span class="jl_post_nav_left">{{ __('lang.website_previous_post') }}</span>
								            </a>
								        </div>
								    </div>
								@endif
								@if(isset($next_blog) && $next_blog!='')
								    <div class="postnav_right">
								        <div class="single_post_arrow_content">
								            <a href="{{ url('blog/'.$next_blog->slug) }}{{ request()->getQueryString() ? '?'.request()->getQueryString() : '' }}" id="nextpost">
								                {{ \Helpers::getNextPreviousLimitedTitle($next_blog->title) }} 
								                <span class="jl_post_nav_left">{{ __('lang.website_next_post') }}</span>
								            </a>
								        </div>
								    </div>
								@endif
							</div>
						</article>
						@if(isset($recent_articles) && count($recent_articles))
						<div class="related-post">
							<h3>{{__('lang.website_you_may_also_like')}}</h3>
							<div class="related-post-block">								
								@foreach($recent_articles as $recent_article)
									<div class="related-post-box">
										<a href="{{url('blog/'.$recent_article->slug)}}">
											@if($recent_article->image!='')
												<img src="{{ url('uploads/blog/327x250/'.$recent_article->image->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$recent_article->title}}"  style="max-height: 115px;"/>
											@else
												<img src="{{ asset('site-assets/img/1920x982.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$recent_article->title}}"  style="max-height: 115px;"/>
											@endif
										</a>
										<span>
										@if(isset($row->blog_categories) && $row->blog_categories!='')
											@if(isset($row->blog_categories->category) && $row->blog_categories->category!='')	
												<a href="{{url('category/'.$row->blog_categories->category->slug)}}" title="{{$row->blog_categories->category->name}}">{{$row->blog_categories->category->name}}</a>
											@endif
										@endif	
										</span>
										<h3><a href="{{url('blog/'.$recent_article->slug)}}" title="{{$recent_article->title}}">{{\Helpers::getLimitedTitleSlider($recent_article->title)}}</a></h3>
									</div>
								@endforeach								
							</div>
						</div>
						@endif
						<div class="comments-area">
							@if(isset($comments) && count($comments))
							<h2 class="comments-title">{{count($comments)}} {{__('lang.website_comments')}}</h2>
							<ol class="comment-list">								
								@foreach($comments as $comment_data)
								<li class="comment byuser comment-author-admin bypostauthor even thread-odd thread-alt depth-1">
									<div class="comment-body">
										<footer class="comment-meta">
											<div class="comment-author vcard">
												@if($comment_data->user!='')
													<img src="{{ url('uploads/user/'.$comment_data->user->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-popular.png') }}`;" alt="{{$comment_data->name}}" class="avatar avatar-72 photo" style="width:70px;" />
												@else
													<img src="{{ asset('site-assets/img/1920x982.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-popular.png') }}`;" alt="{{$comment_data->name}}" class="avatar avatar-72 photo" style="width:70px;"/>
												@endif
												<b class="fn">@if(isset($comment_data->user) && $comment_data->user!='') {{$comment_data->user->name}} @endif</b>
											</div>
											<!-- <div class="comment-metadata">
												16 hours ago											
											</div> -->
										</footer>
										<div class="comment-content">
											<p><?php echo $comment_data->comment; ?></p>
										</div>
									</div>
								</li>
								@endforeach								
							</ol>
							@endif
							@if(Auth::user()!='')
							@if(Auth::user()->id!=1)
							<div class="comment-respond">
								<h2 class="comment-reply-title">{{__('lang.website_leave_a_reply')}}</h2>
								<form method="post" class="comment-form" action="{{url('submit-comment')}}">
									@csrf
									<input type="hidden" name="blog_id" value="@if(isset($row) && $row!=''){{$row->id}}@endif">
									<p class="comment-form-comment">
										<textarea id="comment" name="comment" placeholder="Enter your comment here..." rows="6" required="required"></textarea>
									</p>
									<p class="form-submit">
										<input name="submit" class="submit" value="{{__('lang.website_post_comment')}}" type="submit"/>
									</p>
								</form>
							</div>
							@endif
							@endif
						</div>
						
					</div>
					<div class="col-lg-4 col-md-6 col-12">
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