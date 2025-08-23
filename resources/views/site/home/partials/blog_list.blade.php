@if(count($result))
    @foreach($result as $row)
    <div class="col-lg-6 col-md-12 col-sm-6">
            <div class="type-post">
                <div class="entry-cover">
                    <div class="post-meta">
                        <span class="byline">
                            @if(Auth::user()!='')
                                <a href="javascript:;" onclick="addRemoveBookMarks('{{$row->id}}','home');" title="{{__('lang.website_save_post')}}">
                                    <i class="fa fa-bookmark-o notmarked_{{$row->id}} hide"></i>
                                    <i class="fa fa-bookmark marked_{{$row->id}} hide"></i>
                                    @if($row->blog_bookmark==0)
                                        <i class="fa fa-bookmark-o notmarked_{{$row->id}}"></i>
                                    @else
                                        <i class="fa fa-bookmark marked_{{$row->id}}"></i>
                                    @endif
                                </a>															
                            @endif
                        </span>
                        <span class="post-date"><a href="#"><?php echo \Helpers::showSiteDateFormat($row->schedule_date);?></a></span>
                    </div>
                    <a href="{{url('blog/'.$row->slug)}}">
                        @if($row->image!='')
                            <img src="{{ url('uploads/blog/327x250/'.$row->image->image)}}" onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$row->title}}" />
                        @else
                            <img src="{{ asset('site-assets/img/1920x982.png')}}"  onerror="this.onerror=null; this.src=`{{ url('uploads/no-image-latest.png') }}`;" alt="{{$row->title}}" />
                        @endif
                    </a>
                    <!-- <a href="#"><img src="http://placehold.it/370x247" alt="Post" /></a> -->
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
                        <h3 class="entry-title"><a href="{{url('blog/'.$row->slug)}}" title="{{$row->title}}">{{\Helpers::getLimitedTitle($row->title)}}</a></h3>
                    </div>								
                    <p><?php echo \Helpers::getLimitedDescription($row->description);?></p>
                    <a href="{{url('blog/'.$row->slug)}}" title="{{__('lang.website_read_more')}}">{{__('lang.website_read_more')}}</a>
                </div>
            </div>
        </div>
    @endforeach
    @endif