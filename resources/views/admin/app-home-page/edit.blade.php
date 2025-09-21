@extends('admin/layout/app')
@section('content')

<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/tagify/tagify.css')}}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/select2/select2.css')}}" />

<div class="container-xxl flex-grow-1 container-p-y">
    <form id="add-record" onsubmit="return validateBlog('add-record');" action="{{url('admin/update-app-home-page')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <!--  -->
        <h4 class="fw-bold py-3 mb-4 display-inline-block"><span class="text-muted fw-light"><a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /<a href="{{url('admin/app-home-page')}}"> {{__('lang.admin_app_home_page')}} {{__('lang.admin_list')}} </a>/</span> {{__('lang.admin_add_app_home_page')}}</h4>
        <div class="row">
            <div class="col">
                <div class="card mb-3">

                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
                            <div class="row g-3">
                                <input type="hidden" value="{{$row->id}}" name="id">
                                <div class="col-md-12">
                                    <label class="form-label" for="title"> {{__('lang.admin_title')}} <span class="required">*</span></label>
                                    <input type="text" id="title" value="{{$row->title}}" class="form-control" name="title" placeholder="{{__('lang.admin_title_placeholder')}}" onkeypress="setValue('seo_title',this.value);" onBlur="setValue('seo_title',this.value);" required/>
                                </div>
                                <div class="col-md-12 mb-3 display-inline-block width-25-percent mr-10">
                                    <label class="form-label" for="blog_type_section">{{__('lang.admin_type')}}</label>
                                    <select name="type" class="form-control" onchange="showNewDropdowns(this.value,1);" required>
                                        <option value="">{{__('lang.admin_select_type')}}</option>
                                        <option @if($row->type == 'by_visibility') selected @endif value="by_visibility">{{__('lang.admin_by_visibility')}}</option>
                                        <option @if($row->type == 'by_category') selected @endif value="by_category">{{__('lang.admin_by_category')}}</option>
                                        <option @if($row->type == 'by_all_blogs') selected @endif value="by_all_blogs">{{__('lang.admin_by_all_blogs')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 show-category_1 hide">
                                    <label class="form-label" for="formtabs-first-name"> {{__('lang.admin_category')}} <span class="required">*</span></label>
                                    <select id="category_id" class="select2 form-select category_id" placeholder="{{ __("lang.admin_select_category") }}" name="category_id[]" multiple onchange="showSubCategory('category_id','subCategory');">
                                        <option value="">{{__('lang.admin_select_category')}}</option>
                                        @php
                                        $category_id = explode(',', $row->category_id);
                                        @endphp
                                        @foreach($categories as $category)
                                            <option @if(in_array($category->id,$category_id)) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 show-category_1 hide">
                                    <label class="form-label" for="formtabs-first-name"> {{__('lang.admin_subcategory')}}</label>
                                    @php
                                       $sub_category_id = explode(',', $row->sub_category_id);
                                    @endphp
                                    <select id="sub_category_id" class="select2 form-select sub_category_id subCategory" name="sub_category_id[]" multiple>
                                        @foreach($sub_categories as $sub_category)
                                        <option @if(in_array($sub_category->id,$sub_category_id)) selected @endif value="{{$sub_category->id}}" @if($row->value!='') @if(in_array($sub_category->id,$row->value)) selected @endif @endif>{{$sub_category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 show-visibility_1 hide">
                                    <label class="form-label" for="visibility">{{__('lang.admin_visbility')}}</label>
                                    <select name="visibility_id" class="form-control blog_type_section_1_visibility">
                                        <option value="">{{__('lang.admin_select_visibility')}}</option>
                                        @foreach($visibility as $visibility)
                                            <option @if($row->visibility_id == $visibility->id) selected  @endif value="{{$visibility->id}}">{{$visibility->display_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="float-right py-3">
                                <input type="submit" id="submit" name="button_name" class="btn btn-primary me-sm-3 me-1" value="{{__('lang.admin_submit')}}"/>
                                <a href="{{url('admin/app-home-page')}}" class="btn btn-label-secondary">{{__('lang.admin_button_cancel')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        var type = "{{$row->type}}"; 
        var visibilityDiv = '.show-visibility_1';
        var categoryDiv = '.show-category_1';
      
        if (type == 'by_visibility') {
            $(visibilityDiv).removeClass('hide');
            $(categoryDiv).addClass('hide');
        } else if (type == 'by_category') {
            $(visibilityDiv).addClass('hide');
            $(categoryDiv).removeClass('hide');
        } else {
            $(visibilityDiv).addClass('hide');
            $(categoryDiv).addClass('hide');
        }
    });
    
    function showNewDropdowns(value, section) {
      var visibilityDiv = '.show-visibility_' + section;
      var categoryDiv = '.show-category_' + section;
    
      if (value == 'by_visibility') {
        $(visibilityDiv).removeClass('hide');
        $(categoryDiv).addClass('hide');
      } else if (value == 'by_category') {
        $(visibilityDiv).addClass('hide');
        $(categoryDiv).removeClass('hide');
      } else {
        $(visibilityDiv).addClass('hide');
        $(categoryDiv).addClass('hide');
      }
}
</script>