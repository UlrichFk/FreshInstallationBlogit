<?php $social = \Helpers::getSocialMedias(6);?>
@if(isset($social) && count($social))
    <aside class="widget widget_social" style="margin-bottom: 30px;">
        <h3 class="widget-title">{{__('lang.website_follow_us')}}</h3>
        <ul>            
            @foreach($social as $social_data)
                <li><a target="_blank" href="{{$social_data->url}}" title="{{$social_data->name}}"><i class="fa {{$social_data->icon}}"></i></a></li>
            @endforeach            
        </ul>
    </aside>
@endif