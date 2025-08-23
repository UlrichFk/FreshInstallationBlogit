@extends('admin/layout/app')
@section('content')
<script src="{{ asset('admin-assets/js/ckeditor.js')}}"></script>
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/tagify/tagify.css')}}" />

<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/select2/select2.css')}}" />

<div class="container-xxl flex-grow-1 container-p-y">
    <form id="edit-record" onsubmit="return" action="{{url('admin/update-short-video')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$row->id}}">
        <!--  -->
        <h4 class="fw-bold py-3 mb-4 display-inline-block"><span class="text-muted fw-light"><a href="{{url('admin/dashboard')}}">{{__('lang.admin_dashboard')}}</a> /<a href="{{url('admin/short-video')}}"> {{__('lang.admin_short_video')}} {{__('lang.admin_list')}} </a>/</span> {{__('lang.admin_edit_short')}}</h4>
        <div class="float-right py-3">
            @if($row->status==2)
                <input type="submit" id="publish" name="button_name" class="btn btn-success me-sm-3 me-1" value="{{__('lang.admin_publish')}}"/>
                <input type="submit" id="submit" name="button_name" class="btn btn-primary me-sm-3 me-1" value="{{__('lang.admin_submit')}}"/>
            @elseif($row->status==3 || $row->status==0)
                <input type="submit" id="publish" name="button_name" class="btn btn-success me-sm-3 me-1" value="{{__('lang.admin_publish')}}"/>         
            @endif
            <input type="submit" id="update" name="button_name" class="btn btn-primary me-sm-3 me-1" value="{{__('lang.admin_update')}}"/>
            <a href="{{url('admin/short-video')}}" class="btn btn-label-secondary">{{__('lang.admin_button_cancel')}}</a>
        </div>
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-12">
                                <label class="form-label" for="title">{{__('lang.admin_title')}} <span class="required">*</span></label>
                                <input type="text" id="title" class="form-control" name="title" placeholder="{{__('lang.admin_title_placeholder')}}" value="{{$row->title}}" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="description">{{__('lang.admin_description')}}</label>
                                <textarea class="form-control" name="description" id="editor" placeholder="{{__('lang.admin_description_placeholder')}}" value="{{$row->description}}">{{$row->description}}</textarea>
                            </div>

                            <input type="hidden" name="video_type" value="youtube_url">

                            <div class="col-md-6 select2-primary youtube_url_input_cls" style="<?=$row->video_url != '' ? '' : 'display:none';?>">
                                <label class="form-label" for="video_url">{{__('lang.admin_youtube_url')}}</label>
                                <input type="text" id="video_url" class="form-control" name="video_url" placeholder="{{__('lang.admin_youtube_url_placeholder')}}" value="{{$row->video_url}}"/>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label" for="schedule_date">{{__('lang.admin_schedule_date')}}</label>
                                <input type="text" class="form-control flatpickr-input active flatpickr-datetime" placeholder="YYYY-MM-DD HH:MM AA" name="schedule_date" readonly="readonly" value="{{$row->schedule_date}}"/>
                            </div>

                            <div class="col-sm-6">
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-uname">{{__('lang.admin_background_image')}} <span class="required">*</span></label>
                                <div class="d-flex-p">
                                    <img src="{{ asset('uploads/short_video')}}/{{$row->background_image}}" id="image-preview" class="rounded me-50 image-preview-cls" alt="profile image" height="80" width="80" onerror="this.onerror=null;this.src=`{{ asset('uploads/image_preview.jpg') }}`" />
                                    <input type="hidden" id="image_name" value="{{$row->background_image}}">
                                    <div class="mt-75 ms-1">
                                        <label class="btn btn-primary me-75 mb-0" for="change-picture">
                                        <span class="d-none d-sm-block"><i class="tf-icons ti ti-upload"></i></span>
                                        <input class="form-control" type="file" name="background_image" id="change-picture" hidden accept="image/*" name="background_image" onclick="showImagePreview('change-picture','image-preview',1080,960);"/>
                                        <span class="d-block d-sm-none">
                                            <i class="me-0" data-feather="edit"></i>
                                        </span>
                                        </label>
                                        <p class="img-label"></p>
                                        <p class="img-resolution">{{__('lang.admin_resolution_background_image')}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>                 
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    ClassicEditor
    .create(document.querySelector('#editor'), {
    })
    .catch(error => {
        console.log(error);
    });
    $(".flatpickr-datetime-new").flatpickr({
      enableTime: true,
      dateFormat: 'Y-m-d H:i'
    });
</script>
@endsection