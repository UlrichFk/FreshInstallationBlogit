<?php $categories = \Helpers::getCategoryForSite(5);?>
@if(isset($categories) && count($categories))
<aside class="widget widget_categories text-center">
    <h3 class="widget-title">{{__('lang.website_categories')}}</h3>
    <ul>
        @foreach($categories as $categories_data)
            <li><a href="{{url('category/'.$categories_data->slug)}}" title="{{$categories_data->name}}">{{$categories_data->name}}</a></li>
        @endforeach        
    </ul>
</aside>
@endif