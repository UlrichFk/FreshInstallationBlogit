<?php $popular = \Helpers::getPopularPosts(4);?>
@if(isset($popular) && count($popular))
    <aside class="widget widget_latestposts">
        <h3 class="widget-title">{{__('lang.website_popular_posts')}}</h3>    
        @foreach($popular as $popular_data)
        <div class="latest-content">
            <a href="{{url('blog/'.$popular_data->slug)}}" title="{{$popular_data->title}}">
                <i>
                    @if($popular_data->image!='')
                        <img src="{{ url('uploads/blog/327x250/'.$popular_data->image->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-popular.png') }}`;" alt="{{$popular_data->title}}" style="width: 100px;" />
                    @else
                        <img src="{{ url('uploads/no-image-popular.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-popular.png') }}`;" alt="{{$popular_data->title}}" />
                    @endif
                </i>
            </a>
            <h5><a title="{{$popular_data->title}}" href="{{url('blog/'.$popular_data->slug)}}">{{\Helpers::getLimitedTitleForSideContent($popular_data->title)}}</a></h5>
            <span><a href="{{url('blog/'.$popular_data->slug)}}"><?php echo \Helpers::showSiteDateFormat($popular_data->schedule_date);?></a></span>
        </div>
        @endforeach
    </aside>
@endif