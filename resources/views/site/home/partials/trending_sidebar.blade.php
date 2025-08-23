<?php $trending_post = \Helpers::getTrendingPosts(3);?>
@if(isset($trending_post) && count($trending_post))
<aside class="widget widget_tranding_post">
    <h3 class="widget-title">{{__('lang.website_trending_posts')}}</h3>
    <div id="trending-widget" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">            
            @php $i=0; @endphp
            @foreach($trending_post as $trending_post_data)
            @php $i++; @endphp
            <div class="carousel-item <?php if($i==1){ echo 'active'; } ?>">
                <div class="trnd-post-box">
                    <div class="post-cover">
                        <a href="{{url('blog/'.$trending_post_data->slug)}}">
                            @if($trending_post_data->image!='')
                                <img src="{{ url('uploads/blog/327x250/'.$trending_post_data->image->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$trending_post_data->title}}"/>
                            @else
                                <img src="{{ url('uploads/no-image-latest.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$trending_post_data->title}}" />
                            @endif
                        </a>
                    </div>
                    <span class="post-category">
                    @if(isset($trending_post_data->blog_categories) && $trending_post_data->blog_categories!='')
                        @if(isset($trending_post_data->blog_categories->category) && $trending_post_data->blog_categories->category!='')	
                            <a href="{{url('category/'.$trending_post_data->blog_categories->category->slug)}}" title="{{$trending_post_data->blog_categories->category->name}}">{{$trending_post_data->blog_categories->category->name}}</a>
                        @endif
                    @endif	
                    </span>
                    <h3 class="post-title"><a href="{{url('blog/'.$trending_post_data->slug)}}">{{$trending_post_data->title}}</a></h3>
                </div>
            </div>
            @endforeach
        </div>
        <ol class="carousel-indicators">
            <li data-target="#trending-widget" data-slide-to="0" class="active"></li>
            <li data-target="#trending-widget" data-slide-to="1"></li>
            <li data-target="#trending-widget" data-slide-to="2"></li>
        </ol>
    </div>
</aside>
@endif