@foreach($result as $row)
    @if($row->key == 'app_name')
    <div class="col-md-3 mb-3">
        <label class="form-label" for="app_name">{{__('lang.admin_app_name')}}</label>
        <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_app_name_placeholder')}}" name="app_name"/>
    </div>
    @endif
    @if($row->key == 'support_email')
    <div class="col-md-3 mb-3">
        <label class="form-label" for="app_name">{{__('lang.admin_support_email')}}</label>
        <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_support_email_placeholder')}}" name="support_email"/>
    </div>
    @endif
    @if($row->key == 'light_mode_primary_color')
    <div class="col-md-3 mb-3">
        <label class="form-label" for="light_mode_primary_color">{{__('lang.admin_light_mode_primary_color')}}</label>
        <input type="color" id="basic-icon-default-uname" class="form-control dt-uname" name="light_mode_primary_color" value="{{$row->value}}">
    </div>
    @endif
    @if($row->key == 'dark_mode_primary_color')
    <div class="col-md-3 mb-3">
        <label class="form-label" for="dark_mode_primary_color">{{__('lang.admin_dark_mode_secondary_color')}}</label>
        <input type="color" id="basic-icon-default-uname" class="form-control dt-uname" name="dark_mode_primary_color" value="{{$row->value}}">
    </div>
    @endif
@endforeach
@foreach($result as $row)
    @if($row->key == 'android_rate_us')
    <div class="col-md-6 mb-3">
        <label class="form-label" for="android_rate_us">{{__('lang.admin_android_rate_us')}}</label>
        <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_android_rate_us_placeholder')}}" name="android_rate_us"/>
    </div>
    @endif
    @if($row->key == 'ios_rate_us')
    <div class="col-md-6 mb-3">
        <label class="form-label" for="ios_rate_us">{{__('lang.admin_ios_rate_us')}}</label>
        <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_ios_rate_us_placeholder')}}" name="ios_rate_us"/>
    </div>
    @endif
@endforeach
@foreach($result as $row)
    @if($row->key == 'app_logo')
    <div class="col-md-4 mb-3">
        <div class="d-flex-p">
        <img src="{{url('uploads/setting/'.$row->value)}}" class="rounded me-50 image-preview-cls" id="app-logo-preview" alt="app_logo" height="80" width="80" onerror="this.onerror=null;this.src=`{{ asset('uploads/image_preview.jpg') }}`"/>
        <div class="img-footer">
            <label class="btn btn-primary me-75 mb-0" for="change-app-logo">
            <span class="d-none d-sm-block"><i class="tf-icons ti ti-upload"></i></span>
            <input class="form-control" type="file" name="app_logo" id="change-app-logo" hidden accept="image/*" name="app_logo" onclick="showImagePreview('change-app-logo','app-logo-preview','','');"/>
            <span class="d-block d-sm-none">
                <i class="me-0" data-feather="edit"></i>
            </span>
            </label>
            <p class="img-label">{{__('lang.admin_app_logo')}}</p>
            <p class="img-resolution">{{__('lang.admin_app_logo_resolution')}}</p>
        </div>
        </div>
    </div>
    @endif
    @if($row->key == 'rectangualr_app_logo')
    <div class="col-md-4 mb-3">
        <div class="d-flex-p">
        <img src="{{url('uploads/setting/'.$row->value)}}" class="rounded me-50 image-preview-cls" id="app-rectangular-logo-preview" alt="rectangualr_app_logo" height="80" width="80" onerror="this.onerror=null;this.src=`{{ asset('uploads/image_preview.jpg') }}`"/>
        <div class="img-footer">
            <label class="btn btn-primary me-75 mb-0" for="change-rectangular-logo">
            <span class="d-none d-sm-block"><i class="tf-icons ti ti-upload"></i></span>
            <input class="form-control" type="file" name="rectangualr_app_logo" id="change-rectangular-logo" hidden accept="image/*" name="rectangualr_app_logo" onclick="showImagePreview('change-rectangular-logo','app-rectangular-logo-preview',379,128);"/>
            <span class="d-block d-sm-none">
                <i class="me-0" data-feather="edit"></i>
            </span>
            </label>
            <p class="img-label">{{__('lang.admin_rectangualr_app_logo')}}</p>
            <p class="img-resolution">{{__('lang.admin_rectangualr_app_logo_resolution')}}</p>
        </div>
        </div>
    </div>
    @endif
    @if($row->key == 'app_splash_screen')
    <div class="col-md-4 mb-3">
        <div class="d-flex-p">
            <img src="{{url('uploads/setting/'.$row->value)}}" class="rounded me-50 image-preview-cls" id="app-splash-screen-preview" alt="app_splash_screen" height="80" width="80" onerror="this.onerror=null;this.src=`{{ asset('uploads/image_preview.jpg') }}`"/>
            <div class="img-footer">
                <label class="btn btn-primary me-75 mb-0" for="change-app-splash-screen">
                <span class="d-none d-sm-block"><i class="tf-icons ti ti-upload"></i></span>
                <input class="form-control" type="file" name="app_splash_screen" id="change-app-splash-screen" hidden accept="image/*" name="app_splash_screen" onclick="showImagePreview('change-app-splash-screen','app-splash-screen-preview','','');"/>
                <span class="d-block d-sm-none">
                    <i class="me-0" data-feather="edit"></i>
                </span>
                </label>
                <p class="img-label">{{__('lang.admin_app_splash_screen')}}</p>
                <p class="img-resolution">{{__('lang.admin_app_splash_screen_resolution')}}</p>
            </div>
        </div>
    </div>
    @endif
@endforeach


<div class="mt-4"></div>
<hr>
<div class="row">
@foreach($result as $row)

    @if($row->key == 'is_autoapprove_enable')
    <div class="col-md-6 mb-3 display-inline-block">
        <label class="switch switch-square">
            <input value="1" type="checkbox" class="switch-input" id="is_autoapprove_enable" name="is_autoapprove_enable" @if($row->value == 1) checked @endif>
            <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{__('lang.admin_is_autoapprove_enable_placeholder')}}</span>
        </label>
    </div>
    @endif
    @if($row->key == 'enable_stories')
    <div class="col-md-6 mb-3 display-inline-block">
        <label class="switch switch-square">
            <input value="1" type="checkbox" class="switch-input" id="enable_stories" name="enable_stories" @if($row->value == 1) checked @endif>
            <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{__('lang.admin_enable_stories_placeholder')}}</span>
        </label>
    </div>
    @endif
    @if($row->key == 'enable_skip')
    <div class="col-md-6 mb-3 display-inline-block">
        <label class="switch switch-square">
            <input value="1" type="checkbox" class="switch-input" id="enable_skip" name="enable_skip" @if($row->value == 1) checked @endif>
            <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{__('lang.admin_enable_skip_placeholder')}}</span>
        </label>
    </div>
    @endif
    @if($row->key == 'enable_select_language_appear')
    <div class="col-md-6 mb-3 display-inline-block">
        <label class="switch switch-square">
            <input value="1" type="checkbox" class="switch-input" id="enable_select_language_appear" name="enable_select_language_appear" @if($row->value == 1) checked @endif>
            <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{__('lang.admin_select_language_appear_or_not_placeholder')}}</span>
        </label>
    </div>
    @endif
    
@endforeach
</div>