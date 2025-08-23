@foreach($result as $row)
    @if($row->key == 'android_schema')
    <div class="col-md-6 mb-3">
        <label class="form-label" for="android_schema">{{__('lang.admin_android_schema')}}</label>
        <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_android_schema_placeholder')}}" name="android_schema"/>
    </div>
    @endif
    @if($row->key == 'playstore_url')
    <div class="col-md-6 mb-3">
        <label class="form-label" for="playstore_url">{{__('lang.admin_playstore_url')}}</label>
        <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_playstore_url_placeholder')}}" name="playstore_url"/>
    </div>
    @endif
    @if($row->key == 'appstore_url')
    <div class="col-md-6 mb-3">
        <label class="form-label" for="appstore_url">{{__('lang.admin_appstore_url')}}</label>
        <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_appstore_url_placeholder')}}" name="appstore_url"/>
    </div>
    @endif
    @if($row->key == 'ios_schema')
    <div class="col-md-6 mb-3">
        <label class="form-label" for="ios_schema">{{__('lang.admin_ios_schema')}}</label>
        <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_ios_schema_placeholder')}}" name="ios_schema"/>
    </div>
    @endif
@endforeach 