<ul id="mainmenu" class="jl_main_menu">
    <li class="menu-item ">
    <!-- /menu-item-has-children -->
        <a href="{{url('/')}}">{{__('lang.website_home')}}<span class="border-menu"></span></a>
        <!-- <ul class="sub-menu">
            <li class="menu-item">
                <a href="{{url('/?home=home_1')}}">{{__('lang.website_home_1')}}<span class="border-menu"></span></a>
            </li>
            <li class="menu-item">
                <a href="{{url('/?home=home_2')}}">{{__('lang.website_home_2')}}<span class="border-menu"></span></a>
            </li>
            <li class="menu-item">
                <a href="{{url('/?home=home_3')}}">{{__('lang.website_home_3')}}<span class="border-menu"></span></a>
            </li>
            <li class="menu-item">
                <a href="{{url('/?home=home_4')}}">{{__('lang.website_home_4')}}<span class="border-menu"></span></a>
            </li>
            <li class="menu-item">
                <a href="{{url('/?home=home_4')}}">{{__('lang.website_home_5')}}<span class="border-menu"></span></a>
            </li>
        </ul> -->
    </li>
    <?php $categoryList = \Helpers::getCategoryForSite(); 
        $cateoryCount = 0;
        if(count($categoryList) > 4){
            $cateoryCount = 4;
        }else{
            $cateoryCount = count($categoryList);
        }
    ?>
    @for($j = 0; $j < $cateoryCount; $j++)
        @if(isset($categoryList[$j]->sub_category) && count($categoryList[$j]->sub_category))
        <li class="menu-item @if(isset($categoryList[$j]->sub_category) && count($categoryList[$j]->sub_category)) menu-item-has-children @endif">
            <a href="javascript:;">{{$categoryList[$j]->name}}<span class="border-menu"></span></a>
            @if(isset($categoryList[$j]->sub_category) && count($categoryList[$j]->sub_category))
            <ul class="sub-menu"> 
                <li class="menu-item">
                    <a href="{{url('/category/'.$categoryList[$j]->slug)}}">{{__('messages.all')}} {{$categoryList[$j]->name}}<span class="border-menu"></span></a>
                </li> 
                @foreach($categoryList[$j]->sub_category as $subcategory)
                <li class="menu-item">
                    <a href="{{url('/category/'.$categoryList[$j]->slug.'/'.$subcategory->slug)}}">{{$subcategory->name}}<span class="border-menu"></span></a>
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @else
        <li class="menu-item menu-item-has-children">
            <a href="javascript:;">{{$categoryList[$j]->name}}<span class="border-menu"></span></a>
            <ul class="sub-menu"> 
                <li class="menu-item">
                    <a href="{{url('/category/'.$categoryList[$j]->slug)}}">{{__('messages.all')}} {{$categoryList[$j]->name}}<span class="border-menu"></span></a>
                </li> 
            </ul>
        </li>
        @endif
    @endfor
    @if(isset($categoryList) && count($categoryList)>4)
    <li class="menu-item menu-item-has-children">
        <a href="javascript:;">{{__('lang.website_more')}}<span class="border-menu"></span></a>
        <ul class="sub-menu">
            @for($j = 4; $j < count($categoryList); $j++)
            <li class="menu-item">
                <a href="{{url('/category/'.$categoryList[$j]->slug)}}">{{$categoryList[$j]->name}}<span class="border-menu"></span></a>
            </li>
            @endfor
        </ul>
    </li> 
    @endif
    <li class="menu-item">
        <a href="{{url('all-blogs')}}">{{__('lang.website_all_blogs')}}<span class="border-menu"></span></a>
    </li>
</ul>